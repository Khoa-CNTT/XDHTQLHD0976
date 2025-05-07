<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SignatureController extends Controller
{
    public function sendOtp(Request $request, $contractId)
    {
        $otp = rand(100000, 999999);
        $email = Auth::user()->email;

        Cache::put('otp_' . $email, $otp, now()->addMinutes(5));

        Mail::raw("Mã OTP của bạn để ký hợp đồng là: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Mã OTP Ký Hợp Đồng');
        });

        return redirect()->back()->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }

    public function sign(Request $request, $contractId)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'signature_data' => 'required', // Base64 chữ ký
        ]);

        $cachedOtp = Cache::get('otp_' . Auth::user()->email);

        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return redirect()->back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']);
        }

        $contract = Contract::findOrFail($contractId);

        Signature::create([
            'contract_id' => $contract->id,
            'customer_name' => Auth::user()->name,
            'customer_email' => Auth::user()->email,
            'signature_image' => $request->signature_data,
            'otp_verified_at' => now(),
            'status' => 'Đã ký',
        ]);

        Cache::forget('otp_' . Auth::user()->email);

        return redirect()->route('customer.contracts.index')->with('success', 'Ký hợp đồng thành công!');
    }
}