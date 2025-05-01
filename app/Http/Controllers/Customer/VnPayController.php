<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Contract;
use App\Models\Payment;

class VNPayController extends Controller
{
    public function createPayment(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        // Lấy thông tin cấu hình từ .env
        $vnp_TmnCode = env('VNPAY_TMN_CODE'); // Mã website
        $vnp_HashSecret = env('VNPAY_SECURE_SECRET'); // Chuỗi bí mật
        $vnp_Url = env('VNPAY_PAYMENT_URL') . '/paymentv2/vpcpay.html'; // URL thanh toán
        $vnp_ReturnUrl = route('customer.vnpay.success'); // URL trả về sau thanh toán

        $vnp_TxnRef = uniqid(); // Mã giao dịch
        $vnp_OrderInfo = "Thanh toán hợp đồng #" . $contract->id;
        $vnp_Amount = $contract->total_price * 100; // Số tiền (VNPay yêu cầu nhân 100)
        $vnp_Locale = 'vn'; // Ngôn ngữ
        $vnp_IpAddr = $request->ip(); // Địa chỉ IP của khách hàng

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        // Tạo URL thanh toán
        ksort($inputData);
        $query = "";
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= $key . "=" . $value . "&";
            $query .= urlencode($key) . "=" . urlencode($value) . "&";
        }

        $query = rtrim($query, "&");
        $hashdata = rtrim($hashdata, "&");
        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        // Lưu thông tin thanh toán vào database
        Payment::create([
            'contract_id' => $contract->id,
            'amount' => $contract->total_price,
            'date' => now(),
            'method' => 'VNPay',
            'status' => 'Đang Đợi',
            'order_id' => $vnp_TxnRef,
        ]);

        return redirect($vnp_Url);
    }

    public function paymentSuccess(Request $request)
    {
        $vnp_HashSecret = env('VNPAY_SECURE_SECRET');
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= $key . "=" . $value . "&";
        }
        $hashData = rtrim($hashData, "&");

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {
                Payment::where('order_id', $inputData['vnp_TxnRef'])->update(['status' => 'Hoàn Thành']);
                return redirect()->route('customer.contracts.index')->with('success', 'Thanh toán thành công!');
            } else {
                Payment::where('order_id', $inputData['vnp_TxnRef'])->update(['status' => 'Đã Huỷ']);
                return redirect()->route('customer.contracts.index')->with('error', 'Thanh toán thất bại!');
            }
        } else {
            return redirect()->route('customer.contracts.index')->with('error', 'Chữ ký không hợp lệ!');
        }
    }
}