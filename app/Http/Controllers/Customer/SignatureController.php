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
            
            $duration = $request->input('duration');
            $selectedPrice = $request->input('selected_price');
            
            // Validate duration
            if (empty($duration)) {
                return redirect()->route('customer.services.show', $serviceId)
                                 ->withErrors(['duration' => 'Vui lòng chọn thời hạn hợp đồng.']);
            }
            
            // Validate the duration exists for this service
            $durationInfo = null;
            $availableDurations = $service->contractDurations()->with('duration')->get();
            
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
            
            foreach ($service->contractDurations()->with('duration')->get() as $contractDuration) {
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

            $startDate = $request->contract_date;
            $endDate = Carbon::parse($startDate)->addMonths($months);

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
                'signature_data' => $request->otp, // Lưu mã OTP
                'signature_image' => $request->signature_data, // Lưu base64 ảnh chữ ký
                'identity_card' => $request->identity_card,
                'duration' => $durationInfo->duration->label,
                'status' => 'Đang xử lý',
                'signed_at' => now(),
                'otp_verified_at' => now(),
            ]);

            Cache::forget('otp_' . Auth::user()->email);

            return redirect()->route('customer.contracts.index')->with('success', 'Hợp đồng đã được ký thành công!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('customer.services.index')
                            ->with('error', 'Dịch vụ không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('customer.services.index')
                            ->with('error', 'Đã xảy ra lỗi khi ký hợp đồng: ' . $e->getMessage());
        }
    }
}