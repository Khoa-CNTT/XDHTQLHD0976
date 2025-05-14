<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\Signature;
use App\Models\Duration;
use App\Models\ContractDuration;
use Exception;

class VNPayController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            if (empty(config('vnpay.tmn_code')) || empty(config('vnpay.hash_secret'))) {
                Log::error('VNPay - Missing required configuration. Please check vnpay.php config file and your .env file.');
                return redirect()->back()->with('error', 'Cấu hình thanh toán VNPay chưa được thiết lập. Vui lòng liên hệ quản trị viên.');
            }
            
            $vnp_Url = config('vnpay.url');
            $vnp_Returnurl = route('customer.vnpay.success');
            $vnp_TmnCode = config('vnpay.tmn_code');
            $vnp_IpnUrl = config('vnpay.ipn_url');
            $vnp_HashSecret = config('vnpay.hash_secret');
            
            Log::info('VNPay - Config Values:', [
                'tmn_code' => $vnp_TmnCode,
                'hash_secret' => substr($vnp_HashSecret, 0, 3) . '...' . substr($vnp_HashSecret, -3),
                'return_url' => $vnp_Returnurl
            ]);

            $contractId = $request->contract_id;
            $vnp_TxnRef = $contractId . '-' . time();
        
            session(['vnpay_contract_id' => $contractId]);
            
            $vnp_OrderInfo = 'Thanh toan don hang';
            $vnp_OrderType = config('vnpay.vnp_ordertype');
            $vnp_Amount = $request->amount * 100;
            $vnp_Locale = config('vnpay.vnp_locale');
            $vnp_IpAddr = $request->ip();
            $vnp_CreateDate = date('YmdHis');

            $inputData = [
                "vnp_Version" => config('vnpay.vnp_version'),
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => config('vnpay.vnp_command'),
                "vnp_CreateDate" => $vnp_CreateDate,
                "vnp_CurrCode" => config('vnpay.vnp_currcode'),
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes')),
            ];

            Log::info('VNPay - Input Data for Payment URL:', $inputData);

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

            Log::info('VNPay - Final Redirect URL:', ['url' => $vnp_Url]);

            return redirect($vnp_Url);
        } catch (Exception $e) {
            Log::error('VNPay - Exception in createPayment:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo thanh toán.');
        }
    }

      public function return(Request $request)
    {
        try {
            // Log toàn bộ request để debug
            Log::info('VNPay - All request parameters:', $request->all());
            
       
            if (empty(config('vnpay.hash_secret'))) {
                Log::error('VNPay - Missing hash_secret configuration');
                return redirect()->route('customer.contracts.index')
                    ->with('error', 'Cấu hình thanh toán VNPay không hợp lệ. Vui lòng liên hệ quản trị viên.');
            }
            
            // Xác thực hash và lấy các giá trị từ request
            $txnRef = $request->vnp_TxnRef ?? 'unknown';
            $contractId = session('vnpay_contract_id');
            
            Log::debug('Session contract_id:', ['contract_id' => $contractId]);

            if (!$contractId) {
                // If the session value is missing, try to extract from txnRef
                $parts = explode('-', $txnRef);
                $contractId = $parts[0] ?? null;
                
                if (!$contractId) {
                    Log::error('VNPay - Unable to determine contract ID');
                    return redirect()->route('customer.contracts.index')
                        ->with('error', 'Không thể xác định hợp đồng. Vui lòng liên hệ hỗ trợ.');
                }
            }
            
            // Kiểm tra xem giao dịch đã được xử lý trước đó chưa
            $existingPayment = Payment::where('transaction_id', $request->vnp_TransactionNo)
                                    ->where('status', 'Hoàn Thành')
                                    ->first();

            // Nếu giao dịch đã được xử lý, không xử lý lại
            if ($existingPayment) {
                Log::info("VNPay - Payment already processed for TransactionNo: {$request->vnp_TransactionNo}");
                return redirect()->route('customer.contracts.show', ['id' => $contractId])
                                ->with('success', 'Thanh toán đã được xử lý thành công!');
            }

            // Kiểm tra trạng thái giao dịch
            if ($request->vnp_ResponseCode == '00' && $request->vnp_TransactionStatus == '00') {
                // Bắt đầu transaction để đảm bảo tính nhất quán dữ liệu
                DB::beginTransaction();
                
                try {
                    // Lấy thông tin hợp đồng
                    $contract = Contract::find($contractId);
                    if (!$contract) {
                        DB::rollBack();
                        Log::error("VNPay - Contract not found for ID: $contractId");
                        return redirect()->route('customer.contracts.index')
                            ->with('error', 'Không tìm thấy hợp đồng.');
                    }
                    
                    // Lấy thông tin chữ ký và thời hạn
                    $signature = Signature::where('contract_id', $contractId)->latest()->first();
                    if (!$signature) {
                        DB::rollBack();
                        Log::error("VNPay - Signature not found for Contract ID: $contractId");
                        return redirect()->route('customer.contracts.show', ['id' => $contractId])
                            ->with('error', 'Không tìm thấy chữ ký cho hợp đồng này.');
                    }
                    
                    // Lấy thời hạn từ signature hoặc bảng durations
                    $contractDuration = null;
                    if ($signature->contract_duration_id) {
                        $contractDuration = ContractDuration::find($signature->contract_duration_id);
                    } else {
                        $durationLabel = $signature->duration;
                        $duration = Duration::where('label', $durationLabel)->first();
                        
                        if ($duration) {
                            $contractDuration = ContractDuration::where('service_id', $contract->service_id)
                                                            ->where('duration_id', $duration->id)
                                                            ->first();
                        }
                    }
                    
                    // Kiểm tra contractDuration
                    if (!$contractDuration) {
                        DB::rollBack();
                        Log::error("VNPay - Contract duration not found", [
                            'contract_id' => $contractId,
                            'service_id' => $contract->service_id,
                            'duration_label' => $durationLabel ?? null
                        ]);
                        return redirect()->route('customer.contracts.show', ['id' => $contractId])
                            ->with('error', 'Không tìm thấy thông tin thời hạn hợp đồng.');
                    }
                    
                    // Lưu thanh toán
                   $paymentData = [
    'contract_id' => $contractId,
    'contract_duration_id' => $contractDuration->id,
    'amount' => ($request->vnp_Amount ?? 0) / 100,
    'date' => now(),
    'method' => 'VNPay',
    'transaction_id' => $request->vnp_TransactionNo ?? '',
    'order_id' => $txnRef,
    'payment_type' => $request->vnp_CardType ?? 'ATM',
    'payment_response' => json_encode($request->all()),
    'ipn_response' => null, 
    'error_message' => null, 
    'status' => 'Hoàn Thành'
];
                    
                    Log::info("VNPay - Preparing to create payment record", $paymentData);
                    $payment = Payment::create($paymentData);
                    
                    // Cập nhật trạng thái hợp đồng
                    $contract->status = 'Hoàn thành';
                    $contract->save();
                    
                    // Áp dụng chữ ký công ty
                    $this->addCompanySignature($contractId);
                    
                    // Commit transaction
                    DB::commit();
                    
                    Log::info("VNPay - Payment successful", [
                        'payment_id' => $payment->id,
                        'contract_id' => $contractId,
                        'status' => 'Hoàn thành'
                    ]);
                    
                    return redirect()->route('customer.contracts.show', ['id' => $contractId])
                        ->with('success', 'Thanh toán thành công! ');
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::error("VNPay - Error processing payment", [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return redirect()->route('customer.contracts.show', ['id' => $contractId])
                        ->with('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage());
                }
            } else {
                Log::warning("VNPay - Payment failed", [
                    'contract_id' => $contractId,
                    'response_code' => $request->vnp_ResponseCode
                ]);
                return redirect()->route('customer.contracts.show', ['id' => $contractId])
                    ->with('error', 'Thanh toán không thành công');
            }
        } catch (Exception $e) {
            Log::error('VNPay - Exception in return()', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('customer.contracts.index')
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán: ' . $e->getMessage());
        }
    }

    public function ipn(Request $request)
    {
        try {
            // Log toàn bộ request để debug
            Log::info('VNPay IPN - All request parameters:', $request->all());
            
            // Xác thực hash và lấy các giá trị từ request (code remains the same)
            
            // Kiểm tra trạng thái giao dịch
            if ($request->vnp_ResponseCode == '00' && $request->vnp_TransactionStatus == '00') {
                $txnRef = $request->vnp_TxnRef;
                $parts = explode('-', $txnRef);
                $contractId = $parts[0] ?? null;
                
                if (!$contractId) {
                    Log::error('VNPay IPN - Unable to determine contract ID');
                    return response('{"RspCode":"99","Message":"Unable to determine contract ID"}', 200)
                        ->header('Content-Type', 'application/json');
                }
                
                // Kiểm tra giao dịch đã xử lý chưa
                $existingPayment = Payment::where('transaction_id', $request->vnp_TransactionNo)
                                     ->where('status', 'Hoàn Thành')
                                     ->first();

                if ($existingPayment) {
                    Log::info("VNPay IPN - Payment already processed");
                    return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                        ->header('Content-Type', 'application/json');
                }

                // Bắt đầu transaction
                DB::beginTransaction();
                
                try {
                    // Lấy thông tin hợp đồng
                    $contract = Contract::find($contractId);
                    if (!$contract) {
                        DB::rollBack();
                        Log::error("VNPay IPN - Contract not found for ID: $contractId");
                        return response('{"RspCode":"99","Message":"Contract not found"}', 200)
                            ->header('Content-Type', 'application/json');
                    }
                    
                    // Lấy thông tin chữ ký và thời hạn
                    $signature = Signature::where('contract_id', $contractId)->latest()->first();
                    if (!$signature) {
                        DB::rollBack();
                        Log::error("VNPay IPN - Signature not found for Contract ID: $contractId");
                        return response('{"RspCode":"99","Message":"Signature not found"}', 200)
                            ->header('Content-Type', 'application/json');
                    }
                    
                    // Lấy thời hạn từ signature hoặc bảng durations
                    $contractDuration = null;
                    if ($signature->contract_duration_id) {
                        $contractDuration = ContractDuration::find($signature->contract_duration_id);
                    } else {
                        $durationLabel = $signature->duration;
                        $duration = Duration::where('label', $durationLabel)->first();
                        
                        if ($duration) {
                            $contractDuration = ContractDuration::where('service_id', $contract->service_id)
                                                            ->where('duration_id', $duration->id)
                                                            ->first();
                        }
                    }
                    
                    // Kiểm tra contractDuration
                    if (!$contractDuration) {
                        DB::rollBack();
                        Log::error("VNPay IPN - Contract duration not found");
                        return response('{"RspCode":"99","Message":"Contract duration not found"}', 200)
                            ->header('Content-Type', 'application/json');
                    }
                    
                    // Lưu thanh toán
                   $paymentData = [
    'contract_id' => $contractId,
    'contract_duration_id' => $contractDuration->id,
    'amount' => ($request->vnp_Amount ?? 0) / 100,
    'date' => now(),
    'method' => 'VNPay',
    'transaction_id' => $request->vnp_TransactionNo ?? '',
    'order_id' => $txnRef,
    'payment_type' => $request->vnp_CardType ?? 'ATM',
    'payment_response' => json_encode($request->all()),
    'ipn_response' => json_encode($request->all()),
    'error_message' => null, 
    'status' => 'Hoàn Thành'
];
                    
                    Log::info("VNPay IPN - Preparing to create payment record", $paymentData);
                    $payment = Payment::create($paymentData);
                    
                    // Cập nhật trạng thái hợp đồng
                    $contract->status = 'Hoàn thành';
                    $contract->save();
                    
                    // Áp dụng chữ ký công ty
                    $this->addCompanySignature($contractId);
                    
                    // Commit transaction
                    DB::commit();
                    
                    Log::info("VNPay IPN - Payment successful", [
                        'payment_id' => $payment->id,
                        'contract_id' => $contractId
                    ]);
                    
                    return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                        ->header('Content-Type', 'application/json');
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::error("VNPay IPN - Error processing payment: " . $e->getMessage());
                    return response('{"RspCode":"99","Message":"Error processing payment"}', 200)
                        ->header('Content-Type', 'application/json');
                }
            } else {
                // Xử lý thanh toán thất bại (code remains similar)
                Log::warning("VNPay IPN - Payment FAILED");
                return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                    ->header('Content-Type', 'application/json');
            }
        } catch (Exception $e) {
            Log::error('VNPay IPN - Exception:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response('{"RspCode":"99","Message":"Unknown error"}', 200)
                ->header('Content-Type', 'application/json');
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

        $adminSignatureBase64 = $this->getAdminSignatureBase64();

        if (!$adminSignatureBase64) {
            Log::warning("Không tìm thấy chữ ký admin, dùng ảnh mặc định hoặc null.");
        }

        $signature->update([
            'admin_name' => 'Phạm Quang Ngà',
            'admin_position' => 'Giám đốc',
            'admin_signature_image' => $adminSignatureBase64,
            'admin_signed_at' => now(),
        ]);

        return true;
    } catch (\Exception $e) {
        Log::error("VNPay - Error adding company signature: " . $e->getMessage());
        return false;
    }
}

private function getAdminSignatureBase64()
{
    $folder = 'signatures';
    $fallbackFile = 'signatures/Untitled.png';
    $filename = null;

    // Tìm file chữ ký admin đầu tiên có tên bắt đầu bằng admin_signature
    $files = Storage::disk('public')->files($folder);

    foreach ($files as $file) {
        if (str_starts_with(basename($file), 'admin_signature')) {
            $filename = $file;
            break;
        }
    }

    // Nếu không tìm được thì dùng ảnh mặc định
    if (!$filename || !Storage::disk('public')->exists($filename)) {
        if (!Storage::disk('public')->exists($fallbackFile)) {
            return null; // không có ảnh nào cả
        }
        $filename = $fallbackFile;
    }

    $fullPath = storage_path('app/public/' . $filename);

    if (!file_exists($fullPath)) {
        return null;
    }

    $mimeType = File::mimeType($fullPath);
    $imageContent = Storage::disk('public')->get($filename);

    return 'data:' . $mimeType . ';base64,' . base64_encode($imageContent);
}



}
