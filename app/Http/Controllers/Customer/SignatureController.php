<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Signature;
use App\Models\Service;
use App\Models\Duration;
use App\Models\ContractDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SignatureController extends Controller
{
    public function showSignForm(Request $request, $serviceId)
    {
        try {
            $service = Service::findOrFail($serviceId);
            
            // Kiểm tra xem người dùng đã có hợp đồng cho dịch vụ này chưa và đã ký chưa
            $customerId = Auth::user()->customer->id;
            $existingContract = Contract::where('service_id', $serviceId)
                                      ->where('customer_id', $customerId)
                                      ->first();
                                      
            if ($existingContract) {
                $hasSignature = Signature::where('contract_id', $existingContract->id)->exists();
                if ($hasSignature) {
                    return redirect()->route('customer.contracts.show', $existingContract->id)
                                    ->with('error', 'Bạn đã ký hợp đồng cho dịch vụ này. Không thể ký lại.');
                }
            }
            
            $duration = $request->input('duration');
            $selectedPrice = $request->input('selected_price');
            
            // Validate duration
            if (empty($duration)) {
                return redirect()->route('customer.services.show', $serviceId)
                                 ->withErrors(['duration' => 'Vui lòng chọn thời hạn hợp đồng.']);
            }
            
            // Validate the duration exists for this service
            $durationInfo = null;
            $availableDurations = $service->contractDurations()->with('duration')->join('durations', 'contract_durations.duration_id', '=', 'durations.id')->orderBy('durations.months', 'asc')->get();
            
            foreach ($availableDurations as $contractDuration) {
                $durationCode = Str::slug($contractDuration->duration->label, '_');
                if ($durationCode == $duration) {
                    $durationInfo = $contractDuration;
                    break;
                }
            }
            
            if (!$durationInfo) {
                return redirect()->route('customer.services.show', $serviceId)
                                 ->withErrors(['duration' => 'Thời hạn hợp đồng không hợp lệ.']);
            }
        
            $tempSignature = session('temp_signature');
            return view('customer.contracts.sign', compact('service', 'duration', 'durationInfo', 'tempSignature'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('customer.services.index')
                            ->with('error', 'Dịch vụ không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('customer.services.index')
                            ->with('error', 'Đã xảy ra lỗi khi truy cập form ký hợp đồng: ' . $e->getMessage());
        }
    }
    
    public function sendOtp(Request $request, $serviceId)
    {
        $customerName = Auth::user()->name;
        $customerEmail = Auth::user()->email;

        $otp = rand(100000, 999999);

        Cache::put('otp_' . $customerEmail, $otp, now()->addMinutes(5));

        Mail::raw("Mã OTP của bạn để ký hợp đồng là: $otp", function ($message) use ($customerEmail) {
            $message->to($customerEmail)
                    ->subject('Mã OTP Ký Hợp Đồng');
        });

        return redirect()->back()->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }

    public function sign(Request $request, $serviceId)
    {
        try {
            $request->validate([
                'otp' => 'required|numeric',
                'signature_data' => 'required', // Base64 chữ ký
                'duration' => 'required|string',
                'contract_date' => 'required|date',
                'identity_card' => 'required|string',
                'agreed_terms' => 'required|boolean',
            ]);

            $cachedOtp = Cache::get('otp_' . Auth::user()->email);
            if (!$cachedOtp || $cachedOtp != $request->otp) {
                return redirect()->back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']);
            }

            $service = Service::findOrFail($serviceId);
            $customer = Auth::user()->customer;
            
            // Find the duration info
            $durationCode = $request->duration;
            $durationInfo = null;
            $price = $service->price; // Default price
            $months = 12; // Default months
            
            foreach ($service->contractDurations()->with('duration')->join('durations', 'contract_durations.duration_id', '=', 'durations.id')->orderBy('durations.months', 'asc')->get() as $contractDuration) {
                $currentCode = Str::slug($contractDuration->duration->label, '_');
                if ($currentCode == $durationCode) {
                    $durationInfo = $contractDuration;
                    $price = $contractDuration->price;
                    $months = $contractDuration->duration->months;
                    break;
                }
            }
            
            if (!$durationInfo) {
                return redirect()->back()->withErrors(['duration' => 'Thời hạn hợp đồng không hợp lệ.']);
            }

            $startDate = Carbon::parse($request->contract_date);
            
            // Tính toán ngày hết hạn theo tiêu chuẩn ISO
            // 1. Tính ngày kết thúc từ tháng
            $endDate = $startDate->copy()->addMonths($months);
            
            // 2. Xử lý các trường hợp đặc biệt (như 31 tháng 1 -> 28/29 tháng 2)
            // Nếu ngày bắt đầu là ngày cuối tháng, thì ngày kết thúc cũng là ngày cuối của tháng tương ứng
            if ($startDate->day === $startDate->daysInMonth) {
                $endDate = $endDate->endOfMonth();
            }
            // Nếu ngày bắt đầu lớn hơn số ngày trong tháng kết thúc
            elseif ($startDate->day > $endDate->daysInMonth) {
                $endDate = $endDate->endOfMonth();
            }
            
            // Giữ lại giờ, phút, giây từ ngày bắt đầu
            $endDate->setTime(
                $startDate->hour,
                $startDate->minute,
                $startDate->second
            );

            // Tạo hoặc lấy hợp đồng
            $contract = Contract::where('service_id', $serviceId)
                                ->where('customer_id', $customer->id)
                                ->first();
            if (!$contract) {
                $contract = Contract::create([
                    'service_id' => $serviceId,
                    'customer_id' => $customer->id,
                    'contract_number' => 'HD-' . time(),
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'Chờ xử lý',
                    'total_price' => $price,
                ]);
            }

            // Kiểm tra nếu đã có chữ ký cho hợp đồng này thì không cho ký lại
            $hasSignature = Signature::where('contract_id', $contract->id)->exists();
            if ($hasSignature) {
                return redirect()->back()->withErrors(['signature' => 'Hợp đồng này đã được ký!']);
            }

            // Lưu chữ ký vào DB
            Signature::create([
                'contract_id' => $contract->id,
                'customer_name' => Auth::user()->name,
                'customer_email' => Auth::user()->email,
                'signature_data' => $request->signature_data,
                'signature_image' => $request->signature_data,
                'identity_card' => $request->identity_card,
                'contract_duration_id' => $durationInfo->id,
                'status' => 'Đang xử lý',
                'signed_at' => now(),
                'otp_verified_at' => now()
            ]);
            
            // Tự động thêm chữ ký 
            $this->addCompanySignature($contract->id);

            return redirect()->route('customer.contracts.show', ['id' => $contract->id])
                            ->with('success', 'Bạn đã ký hợp đồng thành công! Vui lòng thanh toán để kích hoạt hợp đồng.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('customer.services.index')
                            ->with('error', 'Dịch vụ không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('customer.services.show', $serviceId)
                            ->with('error', 'Đã xảy ra lỗi khi ký hợp đồng: ' . $e->getMessage());
        }
    }

    /**
     * Thêm chữ ký công ty tự động vào hợp đồng
     */
    private function addCompanySignature($contractId)
    {
        try {
            $contract = Contract::with('signatures')->find($contractId);
            
            if (!$contract || $contract->signatures->isEmpty()) {
                return false;
            }
            
            $signature = $contract->signatures->first();
            
            // Kiểm tra nếu công ty đã ký
            if ($signature->admin_signature_data) {
                return true;
            }
            
            // Lấy thông tin chữ ký công ty từ cấu hình
            $companySignature = config('app.company_signature');
            
            // Cập nhật thông tin chữ ký công ty
            $signature->update([
                'admin_name' => $companySignature['name'],
                'admin_position' => $companySignature['position'],
                'admin_signature_data' => $companySignature['signature_data'] ?? asset('images/company-signature.png'),
                'admin_signature_image' => $companySignature['signature_data'] ?? asset('images/company-signature.png'),
                'admin_signed_at' => now(),
            ]);
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}