<?php

namespace App\Http\Controllers\Customer;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\Service;

use App\Models\Signature;

class ContractController extends Controller
{
    public function index()
{
    $customer = Auth::user()->customer;

    $contracts = Contract::with('service')
                         ->where('customer_id', $customer->id)
                         ->get();

    return view('customer.contracts.index', compact('contracts'));
}

public function show($id)
{
    
    $contract = Contract::with(['customer.user', 'signatures'])->findOrFail($id);
    return view('customer.contracts.show', compact('contract'));
}

    public function showSignForm(Request $request, $serviceId)
{
    
    $service = Service::findOrFail($serviceId);

    
    $duration = $request->query('duration', '6_thang');

    return view('customer.contracts.sign', compact('service', 'duration'));
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
    // Tìm dịch vụ với serviceId
    $service = Service::findOrFail($serviceId);
    
    // Lấy giá trị thời hạn hợp đồng từ request
    $duration = $request->input('duration');

    // Kiểm tra các yêu cầu trong form
    $request->validate([
        'otp' => 'required|numeric',
        'contract_date' => 'required|date',
        'identity_card' => 'required|string',
        'agreed_terms' => 'required|boolean',
        'duration' => 'required|string', // Thời hạn hợp đồng
    ]);

    // Lấy mã OTP đã lưu trong cache
    $cachedOtp = Cache::get('otp_' . Auth::user()->email);

    // Kiểm tra mã OTP, nếu không đúng thì quay lại với lỗi
    if (!$cachedOtp || $cachedOtp != $request->otp) {
        return redirect()->back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn.']);
    }
       // Lấy thông tin khách hàng từ Auth
       $customer = Auth::user()->customer;
    
    // Tạo hợp đồng mới hoặc cập nhật hợp đồng nếu cần
    $contract = Contract::where('service_id', $serviceId)
                        ->where('customer_id', $customer->id)
                        ->first();
                        if (!$contract) {
                            // Nếu không tìm thấy hợp đồng của dịch vụ này, tạo hợp đồng mới
                            $contract = Contract::create([
                                'service_id' => $serviceId,
                                'customer_id' => $customer->id,
                                'contract_number' => 'HD-' . time(),
                                'start_date' => $request->contract_date,
                                'end_date' => now()->addMonths(6), // Ví dụ: hợp đồng kéo dài 6 tháng
                                'status' => 'Chờ xử lý', // Trạng thái mặc định
                                'total_price' => $service->price, // Giá dịch vụ
                            ]);
                        }
                    
                        // Lưu chữ ký hợp đồng vào cơ sở dữ liệu
                        Signature::create([
                            'contract_id' => $contract->id,
                            'customer_name' => Auth::user()->name,
                            'customer_email' => Auth::user()->email,
                            'signature_data' => $request->otp,
                            'identity_card' => $request->identity_card,
                            'duration' => $duration, // Lưu thời hạn hợp đồng
                            'status' => 'Đang xử lý', // Sử dụng giá trị hợp lệ
                            'signed_at' => now(),
                        ]);

    // Xóa OTP khỏi cache sau khi ký
    Cache::forget('otp_' . Auth::user()->email);

    // Chuyển hướng về danh sách hợp đồng với thông báo thành công
    return redirect()->route('customer.contracts.index')->with('success', 'Hợp đồng đã được ký thành công!');
}

    
}
