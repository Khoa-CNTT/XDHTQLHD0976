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
use Carbon\Carbon;
class SignatureController extends Controller
{
    
    private function getDurationLabel($key) {
        $durations = [
            '6_thang' => '6 tháng',
            '1_nam' => '1 năm',
            '3_nam' => '3 năm'
        ];
        return $durations[$key] ?? $key;
    }
    public function showSignForm(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);
    
       
        $duration = $request->input('duration');
        $validDurations = ['6_thang', '1_nam', '3_nam'];
        $durationLabel = $this->getDurationLabel($duration);
        if (!in_array($duration, $validDurations)) {
            return redirect()->route('customer.services.show', $serviceId)
                             ->withErrors(['duration' => 'Vui lòng chọn thời hạn hợp đồng hợp lệ.']);
        }
    
        $tempSignature = session('temp_signature');
        return view('customer.contracts.sign', compact('service', 'duration', 'tempSignature'));
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

        $startDate = $request->contract_date;
        switch ($request->duration) {
            case '6_thang':
                $endDate = Carbon::parse($startDate)->addMonths(6);
                break;
            case '1_nam':
                $endDate = Carbon::parse($startDate)->addYear();
                break;
            case '3_nam':
                $endDate = Carbon::parse($startDate)->addYears(3);
                break;
            default:
                $endDate = Carbon::parse($startDate)->addYear();
        }

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
                'total_price' => $service->price,
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
            'duration' => $this->getDurationLabel($request->duration),
            'status' => 'Đang xử lý',
            'signed_at' => now(),
            'otp_verified_at' => now(),
        ]);

        Cache::forget('otp_' . Auth::user()->email);

        return redirect()->route('customer.contracts.index')->with('success', 'Hợp đồng đã được ký thành công!');
    }

    
}