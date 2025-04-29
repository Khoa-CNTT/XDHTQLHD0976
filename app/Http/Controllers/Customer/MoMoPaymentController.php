<?php


namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Contract;
use App\Models\Payment;
use App\Http\Controllers\Controller;

class MoMoPaymentController extends Controller
{
    public function showPaymentPage($id)
{
    $contract = Contract::with('service')->findOrFail($id);

    return view('customer.payments.payment', compact('contract'));
}
public function createPayment(Request $request, $id)
{
    $contract = Contract::findOrFail($id);

    // Lấy thông tin từ file .env
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    $partnerCode = env('MOMO_PARTNER_CODE');
    $accessKey = env('MOMO_ACCESS_KEY');
    $secretKey = env('MOMO_SECRET_KEY');
    $redirectUrl = env('MOMO_REDIRECT_URL');
    $ipnUrl = env('MOMO_IPN_URL');

    
    $orderId = uniqid();
    $orderInfo = "Thanh toán hợp đồng #" . $contract->id;
    $amount = (int) $contract->total_price;
    $requestId = time() . "";
    $requestType = "captureWallet";
    $extraData = ""; 

    $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";

 
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode' => $partnerCode,
        'accessKey' => $accessKey,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature,
    ];
    Payment::create([
        'contract_id' => $contract->id,
        'amount' => $amount,
        'date' => now(),
        'method' => 'MoMo',
        'status' => 'Đang Đợi',
        'order_id' => $orderId,
        'payment_type' => $requestType,
    ]);
    $response = Http::post($endpoint, $data);
    $result = $response->json();

    Log::info('Generated Order ID:', ['orderId' => $orderId]);
    Log::info('MoMo API Request Data:', $data);
    Log::info('MoMo API Response:', $result);
    Log::info('Raw Hash:', ['rawHash' => $rawHash]);
Log::info('Generated Signature:', ['signature' => $signature]);

   
    if (isset($result['payUrl'])) {
        return redirect($result['payUrl']);
    } else {
        return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo thanh toán: ' . $result['message']);
    }
}

    public function paymentSuccess(Request $request)
    {
 
        return redirect()->route('customer.contracts.index')->with('success', 'Thanh toán thành công!');
    }

    public function paymentIpn(Request $request)
{
    $data = $request->all();


    $partnerCode = env('MOMO_PARTNER_CODE');
    $accessKey = env('MOMO_ACCESS_KEY');
    $secretKey = env('MOMO_SECRET_KEY');

    $orderId = $data['orderId'];
    $requestId = $data['requestId'];
    $amount = $data['amount'];
    $orderInfo = $data['orderInfo'];
    $orderType = $data['orderType'];
    $transId = $data['transId'];
    $message = $data['message'];
    $localMessage = $data['localMessage'];
    $responseTime = $data['responseTime'];
    $errorCode = $data['errorCode'];
    $payType = $data['payType'];
    $extraData = $data['extraData'];
    $m2signature = $data['signature'];

 
    $rawHash = "partnerCode=$partnerCode&accessKey=$accessKey&requestId=$requestId&amount=$amount&orderId=$orderId&orderInfo=$orderInfo&orderType=$orderType&transId=$transId&message=$message&localMessage=$localMessage&responseTime=$responseTime&errorCode=$errorCode&payType=$payType&extraData=$extraData";


    $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

    
    if ($m2signature == $partnerSignature) {
        if ($errorCode == '0') {
            Payment::where('order_id', $orderId)->update(['status' => 'Thành Công']);
            Log::info("Giao dịch thành công: $orderId");
            return response()->json(['message' => 'Giao dịch thành công'], 200);
        } else {
            Payment::where('order_id', $orderId)->update(['status' => 'Thất Bại']);
            Log::warning("Giao dịch thất bại: $message");
            return response()->json(['message' => 'Giao dịch thất bại'], 400);
        }
    } else {
        Log::error("Chữ ký không hợp lệ. Giao dịch có thể bị giả mạo.");
        return response()->json(['message' => 'Chữ ký không hợp lệ'], 400);
    }
}

            public function queryTransaction($orderId)
{
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/query";
    $partnerCode = env('MOMO_PARTNER_CODE');
    $accessKey = env('MOMO_ACCESS_KEY');
    $secretKey = env('MOMO_SECRET_KEY');
    $requestId = time();

    $rawHash = "accessKey=$accessKey&orderId=$orderId&partnerCode=$partnerCode&requestId=$requestId";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = [
        'partnerCode' => $partnerCode,
        'requestId' => $requestId,
        'orderId' => $orderId,
        'requestType' => 'transactionStatus',
        'signature' => $signature,
    ];
    $transactionStatus = $this->queryTransaction($orderId);
Log::info('Transaction Status:', $transactionStatus);
    $response = Http::post($endpoint, $data);
    $result = $response->json();

    Log::info('Transaction Query Response:', $result);

    return $result;
}
}

