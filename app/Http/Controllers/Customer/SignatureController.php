<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Signature;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SignatureController extends Controller
{
    /**
     * Hiển thị form ký hợp đồng.
     */
    public function showSignForm(Request $request, $serviceId)
    {
        try {
            $service = Service::findOrFail($serviceId);
            $customerId = Auth::user()->customer->id;

            // Kiểm tra hợp đồng đã ký chưa
            $existingContract = Contract::where('service_id', $serviceId)
                ->where('customer_id', $customerId)
                ->first();

            if ($existingContract && Signature::where('contract_id', $existingContract->id)->exists()) {
                return redirect()->route('customer.contracts.show', $existingContract->id)
                    ->with('error', 'Bạn đã ký hợp đồng cho dịch vụ này. Không thể ký lại.');
            }

            $duration = $request->input('duration');
            if (empty($duration)) {
                return redirect()->route('customer.services.show', $serviceId)
                    ->withErrors(['duration' => 'Vui lòng chọn thời hạn hợp đồng.']);
            }

            // Lấy thông tin thời hạn hợp lệ
            $durationInfo = null;
            $availableDurations = $service->contractDurations()->with('duration')->get();
            foreach ($availableDurations as $contractDuration) {
                $durationCode = Str::slug($contractDuration->duration->label, '_');
                if ($durationCode === $duration) {
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
            Log::error('Show sign form error', ['error' => $e->getMessage()]);
            return redirect()->route('customer.services.index')
                ->with('error', 'Đã xảy ra lỗi khi truy cập form ký hợp đồng.');
        }
    }

    /**
     * Gửi mã OTP qua email.
     */
    public function sendOtp(Request $request, $serviceId)
    {
        $user = Auth::user();
        $otp = random_int(100000, 999999);

        Cache::put('otp_' . $user->email, $otp, now()->addMinutes(5));

        try {
            Mail::raw("Mã OTP của bạn để ký hợp đồng là: $otp", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Mã OTP Ký Hợp Đồng');
            });
        } catch (\Exception $e) {
            Log::error('Send OTP error', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Không thể gửi OTP. Vui lòng thử lại.');
        }

        return redirect()->back()->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }

    /**
     * Xử lý ký hợp đồng.
     */
    public function sign(Request $request, $serviceId)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'signature_data' => 'required|string',
            'duration' => 'required|string',
            'contract_date' => 'required|date',
            'agreed_terms' => 'required|boolean',
        ]);

        $user = Auth::user();
        $customer = $user->customer;

        // Kiểm tra OTP
        $cachedOtp = Cache::get('otp_' . $user->email);
        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return redirect()->back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']);
        }

        try {
            $service = Service::findOrFail($serviceId);

            // Lấy thông tin thời hạn hợp lệ
            $durationCode = $request->duration;
            $durationInfo = null;
            $availableDurations = $service->contractDurations()->with('duration')->get();
            foreach ($availableDurations as $contractDuration) {
                $currentCode = Str::slug($contractDuration->duration->label, '_');
                if ($currentCode === $durationCode) {
                    $durationInfo = $contractDuration;
                    break;
                }
            }
            if (!$durationInfo) {
                return redirect()->back()->withErrors(['duration' => 'Thời hạn hợp đồng không hợp lệ.']);
            }

            $price = $durationInfo->price;
            $months = $durationInfo->duration->months;
            $startDate = Carbon::parse($request->contract_date);
            $endDate = $startDate->copy()->addMonths($months);

            // Nếu ngày bắt đầu là cuối tháng hoặc lớn hơn số ngày trong tháng kết thúc
            if ($startDate->day === $startDate->daysInMonth || $startDate->day > $endDate->daysInMonth) {
                $endDate = $endDate->endOfMonth();
            }
            $endDate->setTime($startDate->hour, $startDate->minute, $startDate->second);

            // Tạo hoặc lấy hợp đồng
            $contract = Contract::firstOrCreate(
                [
                    'service_id' => $serviceId,
                    'customer_id' => $customer->id,
                ],
                [
                    'contract_number' => 'HD-' . time(),
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'Chờ xử lý',
                    'total_price' => $price,
                ]
            );

            // Không cho ký lại nếu đã có chữ ký
            if (Signature::where('contract_id', $contract->id)->exists()) {
                return redirect()->back()->withErrors(['signature' => 'Hợp đồng này đã được ký!']);
            }

            // Lưu chữ ký
            Signature::create([
                'contract_id' => $contract->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'signature_data' => $request->signature_data,
                'signature_image' => $request->signature_data,
                'contract_duration_id' => $durationInfo->id,
                'status' => 'Đã ký',
                'signed_at' => now(),
                'otp_verified_at' => now(),
            ]);

            return redirect()->route('customer.contracts.show', ['id' => $contract->id])
                ->with('success', 'Bạn đã ký hợp đồng thành công! Vui lòng thanh toán để kích hoạt hợp đồng.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('customer.services.index')
                ->with('error', 'Dịch vụ không tồn tại hoặc đã bị xóa.');
        } catch (\Exception $e) {
            Log::error('Sign contract error', ['error' => $e->getMessage()]);
            return redirect()->route('customer.services.show', $serviceId)
                ->with('error', 'Đã xảy ra lỗi khi ký hợp đồng. Vui lòng thử lại.');
        }
    }
}