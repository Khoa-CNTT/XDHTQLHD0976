<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Contract;
use App\Models\Payment;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class MoMoPaymentController extends Controller
{
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $endpoint;
    private $redirectUrl;
    private $ipnUrl;

    public function __construct()
    {
        $this->partnerCode = env('MOMO_PARTNER_CODE');
        $this->accessKey = env('MOMO_ACCESS_KEY');
        $this->secretKey = env('MOMO_SECRET_KEY');
        $this->endpoint = env('MOMO_ENDPOINT');
        $this->redirectUrl = env('MOMO_REDIRECT_URL', route('momo.return'));
        $this->ipnUrl = env('MOMO_IPN_URL', route('momo.ipn'));
        Log::info('Redirect URL:', ['redirectUrl' => $this->redirectUrl]);
        Log::info('IPN URL:', ['ipnUrl' => $this->ipnUrl]);
    }

    /**
     * Hiển thị form thanh toán
     */
    public function showPaymentForm($contractId)
    {
        $contract = Contract::with('service')->findOrFail($contractId);
        return view('payments.momo', compact('contract'));
    }

    /**
     * Tạo yêu cầu thanh toán MoMo
     */
    public function createPayment(Request $request, $contractId)
    {
        Log::info('Bắt đầu tạo thanh toán MoMo cho hợp đồng: ' . $contractId);
        $contract = Contract::findOrFail($contractId);
    
        Log::info('Thông tin hợp đồng:', [
            'contract_id' => $contract->id,
            'total_price' => $contract->total_price,
            'status' => $contract->status
        ]);
    
        // Tạo các thông tin giao dịch
        $orderId = uniqid('order_', true);
        Log::info('Tạo giao dịch MoMo với orderId:', ['orderId' => $orderId]);
        $amount = (int) $contract->total_price; // Đảm bảo số tiền là số nguyên
        Log::info('Số tiền gửi đến MoMo:', ['amount' => $amount]);
        $orderInfo = "Thanh toán hợp đồng #" . $contract->id;
        $requestType = "captureWallet"; // Sử dụng loại thanh toán "captureWallet"
        $extraData = ""; // Dữ liệu bổ sung (nếu có)
        $requestId = time() . "";
    
        // Tạo signature
        $rawHash = "accessKey=" . $this->accessKey . 
                  "&amount=" . $amount . 
                  "&extraData=" . $extraData . 
                  "&ipnUrl=" . $this->ipnUrl . 
                  "&orderId=" . $orderId . 
                  "&orderInfo=" . $orderInfo . 
                  "&partnerCode=" . $this->partnerCode . 
                  "&redirectUrl=" . $this->redirectUrl . 
                  "&requestId=" . $requestId . 
                  "&requestType=" . $requestType;
    
        $signature = hash_hmac("sha256", $rawHash, $this->secretKey);
        Log::info('Raw Hash:', ['rawHash' => $rawHash]);
        Log::info('Chữ ký được tạo:', ['signature' => $signature]);
    
        // Tạo payment record trước khi gọi API
        $payment = Payment::create([
            'contract_id' => $contract->id,
            'amount' => $amount,
            'date' => Carbon::today(),
            'method' => 'MoMo',
            'order_id' => $orderId,
            'payment_type' => $requestType,
            'request_id' => $requestId,
            'partner_code' => $this->partnerCode,
            'signature' => $signature,
            'status' => 'Đang Đợi'
        ]);
        $expiryTime = Carbon::now()->addMinutes(15)->timestamp;
        // Dữ liệu gửi đến MoMo
        $data = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => env('APP_NAME', 'Your Company'),
            'storeId' => 'MomoStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $this->redirectUrl,
            'ipnUrl' => $this->ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'expiryTime' => $expiryTime
        ];
    
        Log::info('Dữ liệu gửi đến MoMo:', $data);
    
        // Gọi API MoMo
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->timeout(30)->post($this->endpoint, $data);
    
            $result = $response->json();
            Log::info('Phản hồi từ MoMo:', $result);
    
            // Kiểm tra phản hồi từ API MoMo
            if (isset($result['payUrl'])) {
                $payment->update([
                    'payment_response' => json_encode($result),
                    'request_id' => $requestId,
                    'partner_code' => $this->partnerCode,
                    'signature' => $signature,
                    'status' => 'Đang Đợi'
                ]);
                return redirect($result['payUrl']);
            }
    
            // Xử lý lỗi từ API MoMo
            $errorMsg = $result['localMessage'] ?? $result['message'] ?? 'Lỗi không xác định';
            Log::error('MoMo API Error: ' . $errorMsg, $result);
            $payment->update([
                'ipn_response' => json_encode($data),
                'transaction_id' => $data['transId'] ?? null,
                'status' => $data['errorCode'] == '0' ? 'Hoàn Thành' : 'Thất Bại',
                'error_message' => $data['message'] ?? null
            ]);
    
            return back()->with('error', 'Không thể khởi tạo thanh toán: ' . $errorMsg);
        } catch (\Exception $e) {
            Log::error('MoMo API Exception: ' . $e->getMessage());
            $payment->update([
                'status' => 'Thất Bại',
                'error_message' => $e->getMessage()
            ]);
    
            return back()->with('error', 'Lỗi kết nối đến MoMo: ' . $e->getMessage());
        }
    }
    /**
     * Xử lý kết quả trả về từ MoMo
     */
    public function paymentReturn(Request $request)
    {
        $orderId = $request->input('orderId');
        $payment = Payment::where('order_id', $orderId)->first();
    
        if (!$payment) {
            Log::error('MoMo Payment Return: Không tìm thấy payment với orderId: ' . $orderId);
            return redirect()->route('customer.contracts.index')->with('error', 'Không tìm thấy giao dịch.');
        }
    
        // Kiểm tra trạng thái giao dịch thực tế
        $transaction = $this->queryTransaction($orderId);
        Log::info('Trạng thái giao dịch:', $transaction);
    
        if ($transaction['errorCode'] == 0) {
            $payment->update([
                'status' => 'Hoàn Thành',
                'transaction_id' => $transaction['transId'],
                'payment_response' => json_encode($transaction)
            ]);
    
            Contract::where('id', $payment->contract_id)
                ->update(['status' => 'Hoàn thành']);
    
            return redirect()->route('customer.contracts.index', $payment->contract_id)
                ->with('success', 'Thanh toán thành công!');
        }
    
        $payment->update([
            'status' => 'Thất Bại',
            'error_message' => $transaction['message'] ?? 'Thanh toán thất bại'
        ]);
    
        return redirect()->route('customer.contracts.index', $payment->contract_id)
            ->with('error', 'Thanh toán thất bại.');
    }

    /**
     * Xử lý IPN (Instant Payment Notification) từ MoMo
     */
    public function paymentIpn(Request $request)
    {
        
        $data = $request->all();
        Log::info('MoMo IPN Data:', $data);

        $orderId = $data['orderId'] ?? null;
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            Log::error('MoMo IPN: Không tìm thấy payment với orderId: ' . $orderId);
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Kiểm tra chữ ký
        $rawHash = "partnerCode=" . $data['partnerCode'] . 
                  "&accessKey=" . $data['accessKey'] . 
                  "&requestId=" . $data['requestId'] . 
                  "&amount=" . $data['amount'] . 
                  "&orderId=" . $data['orderId'] . 
                  "&orderInfo=" . $data['orderInfo'] .
                  "&orderType=" . $data['orderType'] . 
                  "&transId=" . $data['transId'] . 
                  "&message=" . $data['message'] . 
                  "&localMessage=" . $data['localMessage'] . 
                  "&responseTime=" . $data['responseTime'] . 
                  "&errorCode=" . $data['errorCode'] .
                  "&payType=" . $data['payType'] . 
                  "&extraData=" . $data['extraData'];

        $partnerSignature = hash_hmac("sha256", $rawHash, $this->secretKey);

        if ($data['signature'] !== $partnerSignature) {
            Log::error('MoMo IPN: Chữ ký không hợp lệ', [
                'received' => $data['signature'],
                'calculated' => $partnerSignature
            ]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        // Cập nhật payment
        $payment->update([
            'ipn_response' => json_encode($data),
            'transaction_id' => $data['transId'] ?? null
        ]);

        // Xử lý kết quả thanh toán
        if ($data['errorCode'] == '0') {
            $payment->update([
                'status' => 'Hoàn Thành'
            ]);

            // Cập nhật hợp đồng
            Contract::where('id', $payment->contract_id)
                ->update(['status' => 'Hoàn thành']);
        } else {
            $payment->update([
                'status' => 'Thất Bại',
                'error_message' => $data['message'] ?? 'Thanh toán thất bại'
            ]);
        }

        $contract = Contract::find($payment->contract_id);
if (!$contract) {
    Log::error('Contract not found for payment: ' . $payment->id);
    return response()->json(['error' => 'Contract not found'], 404);
}
    }

    /**
     * Truy vấn trạng thái giao dịch từ MoMo
     */
    private function queryTransaction($orderId)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/query";
        $requestId = time() . "";
        $requestType = "transactionStatus";

        $rawHash = "accessKey=" . $this->accessKey . 
                  "&orderId=" . $orderId . 
                  "&partnerCode=" . $this->partnerCode . 
                  "&requestId=" . $requestId;

        $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        try {
            $response = Http::timeout(15)->post($endpoint, $data);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Lỗi query transaction: ' . $e->getMessage());
            return ['errorCode' => 99, 'message' => $e->getMessage()];
        }
    }
}