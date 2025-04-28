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
    
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        Log::info('MoMo Config:', [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'secretKey' => $secretKey,
        ]);
  
    $orderId = time(); 
    $orderInfo = "Thanh toán hợp đồng #" . $contract->id;
    $amount = (int) $contract->total_price; 
    $redirectUrl = route('customer.momo.success'); 
    $ipnUrl = route('customer.momo.ipn'); 
    $extraData = ""; 
    
        
    $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$orderId&requestType=captureWallet";
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
    $data = [
        'partnerCode' => $partnerCode,
        'accessKey' => $accessKey,
        'requestId' => $orderId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'extraData' => $extraData,
        'requestType' => 'captureWallet',
        'signature' => $signature,
    ];
    Log::info('MoMo API Endpoint:', ['endpoint' => $endpoint]);
       
        Log::info('MoMo API Request Data:', $data);
        $response = Http::post($endpoint, $data);
        $result = $response->json();
        Log::info('MoMo API Response:', $result);
    
        
    
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
        $partnerCode = $data['partnerCode'];
        $accessKey = $data['accessKey'];
        $orderId = $data['orderId'];
        $amount = $data['amount'];
        $orderInfo = $data['orderInfo'];
        $errorCode = $data['errorCode'];
        $transId = $data['transId'];
        $message = $data['message'];
        $localMessage = $data['localMessage'];
        $responseTime = $data['responseTime'];
        $payType = $data['payType'];
        $extraData = $data['extraData'];
        $m2signature = $data['signature'];

   
        $rawHash = "partnerCode=$partnerCode&accessKey=$accessKey&requestId=$orderId&amount=$amount&orderId=$orderId&orderInfo=$orderInfo&orderType=captureWallet&transId=$transId&message=$message&localMessage=$localMessage&responseTime=$responseTime&errorCode=$errorCode&payType=$payType&extraData=$extraData";
        $partnerSignature = hash_hmac("sha256", $rawHash, "YOUR_SECRET_KEY");

        if ($m2signature == $partnerSignature) {
            if ($errorCode == '0') {
                $contractId = explode('#', $orderInfo)[1];
                $contract = Contract::findOrFail($contractId);
                $contract->status = 'Hoàn thành';
                $contract->save();
        
                Payment::create([
                    'contract_id' => $contract->id,
                    'amount' => $amount,
                    'date' => now(),
                    'method' => 'MoMo',
                    'status' => 'Hoàn Thành',
                ]);
            } else {
                // Thanh toán thất bại
                Log::warning("Thanh toán MoMo thất bại, lỗi: $message");
            }
        } else {
            // Kiểm tra chữ ký không hợp lệ
            Log::warning("Chữ ký không hợp lệ. Giao dịch có thể bị giả mạo.");
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

    $response = Http::post($endpoint, $data);
    return $response->json();
}
}

