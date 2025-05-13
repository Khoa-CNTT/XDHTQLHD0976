<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

            // Generate a unique transaction reference using contract ID plus timestamp
            // This ensures each payment attempt has a unique ID to prevent "transaction already exists" errors
            $contractId = $request->contract_id;
            $vnp_TxnRef = $contractId . '-' . time();
            
            // Store the contract ID in the session so we can retrieve it in the return method
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
            
            // Check if required configuration is present
            if (empty(config('vnpay.hash_secret'))) {
                Log::error('VNPay - Missing hash_secret configuration');
                return redirect()->route('customer.contracts.index')
                    ->with('error', 'Cấu hình thanh toán VNPay không hợp lệ. Vui lòng liên hệ quản trị viên.');
            }
            
            $vnp_HashSecret = config('vnpay.hash_secret');
            Log::info('VNPay - Hash Secret Config:', ['hash_secret' => substr($vnp_HashSecret, 0, 3) . '...' . substr($vnp_HashSecret, -3)]);
            
            $inputData = [];
            foreach ($request->all() as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }

            Log::info('VNPay - Return Data Received:', $inputData);

            $vnp_SecureHash = $request->vnp_SecureHash;
            unset($inputData['vnp_SecureHash']);
            unset($inputData['vnp_SecureHashType']);
            
            // Sắp xếp mảng theo key
            ksort($inputData);
            
            // Build hashData theo chuẩn VNPay (không encode)
            $hashData = '';
            foreach ($inputData as $key => $value) {
                if (!empty($hashData)) {
                    $hashData .= '&' . $key . "=" . $value;
                } else {
                    $hashData = $key . "=" . $value;
                }
            }
            
            // Tạo secure hash
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            
            // Log để debug
            Log::info('VNPay - hashData String (VNPAY standard):', ['hashData' => $hashData]);
            Log::info('VNPay - Calculated Secure Hash:', ['hash' => $secureHash]);
            Log::info('VNPay - Received Secure Hash:', ['hash' => $vnp_SecureHash]);

            // Extract the original contract ID from the txnRef (format: contractId-timestamp)
            $txnRef = $request->vnp_TxnRef ?? 'unknown';
            $contractId = session('vnpay_contract_id');
            $contractDurationId = session('vnpay_contract_duration_id', 1); // Default to 1 if not set
            
            if (!$contractId) {
                // If the session value is missing, try to extract from txnRef
                $parts = explode('-', $txnRef);
                $contractId = $parts[0] ?? $txnRef;
                
                // Try to get the contract_duration_id from the contract
                $contract = Contract::find($contractId);
                if ($contract && $contract->signatures && $contract->signatures->count() > 0) {
                    $signature = $contract->signatures->first();
                    // Find the duration by label
                    $duration = Duration::where('label', $signature->duration)->first();
                    if ($duration) {
                        $contractDuration = ContractDuration::where('service_id', $contract->service_id)
                            ->where('duration_id', $duration->id)
                            ->first();
                        
                        if ($contractDuration) {
                            $contractDurationId = $contractDuration->id;
                        }
                    }
                }
            }
            
            Log::info('VNPay - Extracted Data:', [
                'contract_id' => $contractId, 
                'txnRef' => $txnRef,
                'contract_duration_id' => $contractDurationId
            ]);

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
                // Lưu thanh toán thành công
                try {
                    $contract = Contract::find($contractId);
                    if ($contract) {
                        // Tìm signature gần nhất của hợp đồng này
                        $signature = Signature::where('contract_id', $contractId)->latest()->first();
                        
                        if ($signature) {
                            // Lấy duration từ signature
                            $durationLabel = $signature->duration;
                            
                            // Tìm duration_id
                            $duration = Duration::where('label', $durationLabel)->first();
                            
                            if ($duration) {
                                // Tìm contract_duration_id
                                $contractDuration = ContractDuration::where('service_id', $contract->service_id)
                                                                  ->where('duration_id', $duration->id)
                                                                  ->first();
                                
                                if ($contractDuration) {
                                    // Lưu thanh toán thành công với contract_duration_id
                                    Payment::create([
                                        'contract_id' => $contractId,
                                        'contract_duration_id' => $contractDuration->id,
                                        'amount' => ($request->vnp_Amount ?? 0) / 100,
                                        'date' => now(),
                                        'method' => 'VNPay',
                                        'transaction_id' => $request->vnp_TransactionNo ?? null,
                                        'order_id' => $txnRef,
                                        'payment_type' => $request->vnp_CardType ?? null, 
                                        'payment_response' => json_encode($request->all()),
                                        'status' => 'Hoàn Thành'
                                    ]);
                                    
                                    // Cập nhật trạng thái hợp đồng
                                    $contract->status = 'Hoạt động';
                                    $contract->save();
                                    
                                    // Tự động áp dụng chữ ký của công ty
                                    $this->addCompanySignature($contractId);
                                    
                                    Log::info("VNPay - Contract status updated for Contract ID: $contractId", [
                                        'old_status' => $contract->getOriginal('status'), 
                                        'new_status' => 'Hoạt động'
                                    ]);
                                }
                            }
                        }
                    }
                    
                    Log::info("VNPay - Payment record created successfully");
                } catch (Exception $e) {
                    Log::error("VNPay - Error creating payment record: " . $e->getMessage());
                    return redirect()->route('customer.contracts.show', ['id' => $contractId])
                        ->with('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $e->getMessage());
                }
                
                Log::info("VNPay - Payment SUCCESSFUL for Contract ID: $contractId");
                return redirect()->route('customer.contracts.show', ['id' => $contractId])
                                ->with('success', 'Thanh toán thành công! Hợp đồng đã được cập nhật trạng thái.');
            } else {
                Log::warning("VNPay - Payment FAILED for Contract ID: $contractId, ResponseCode: " . $request->vnp_ResponseCode);
                return redirect()->route('customer.contracts.show', ['id' => $contractId])
                                ->with('error', 'Thanh toán không thành công');
            }
        } catch (Exception $e) {
            Log::error('VNPay - Exception in return():', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('customer.contracts.index')
                             ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán: ' . $e->getMessage());
        }
    }

    public function ipn(Request $request)
    {
        try {
            // Log toàn bộ request để debug
            Log::info('VNPay IPN - All request parameters:', $request->all());
            
            // Check if required configuration is present
            if (empty(config('vnpay.hash_secret'))) {
                Log::error('VNPay IPN - Missing hash_secret configuration');
                return response('{"RspCode":"99","Message":"Invalid configuration"}', 200)
                    ->header('Content-Type', 'application/json');
            }
            
            $vnp_HashSecret = config('vnpay.hash_secret');
            Log::info('VNPay IPN - Hash Secret Config:', ['hash_secret' => substr($vnp_HashSecret, 0, 3) . '...' . substr($vnp_HashSecret, -3)]);
            
            $inputData = [];
            foreach ($request->all() as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            
            Log::info('VNPay IPN - Data Received:', $inputData);

            $vnp_SecureHash = $request->vnp_SecureHash;
            unset($inputData['vnp_SecureHash']);
            unset($inputData['vnp_SecureHashType']);
            
            // Sắp xếp mảng theo key
            ksort($inputData);
            
            // Build hashData theo chuẩn VNPay (không encode)
            $hashData = '';
            foreach ($inputData as $key => $value) {
                if (!empty($hashData)) {
                    $hashData .= '&' . $key . "=" . $value;
                } else {
                    $hashData = $key . "=" . $value;
                }
            }
            
            // Tạo secure hash
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            // Log debug
            Log::info('VNPay IPN - hashData String (VNPAY standard):', ['hashData' => $hashData]);
            Log::info('VNPay IPN - Calculated Secure Hash:', ['hash' => $secureHash]);
            Log::info('VNPay IPN - Received Secure Hash:', ['hash' => $vnp_SecureHash]);

            // Kiểm tra trạng thái giao dịch
            if ($request->vnp_ResponseCode == '00' && $request->vnp_TransactionStatus == '00') {
                $txnRef = $request->vnp_TxnRef;
                
                // Extract contract ID from txnRef (format: contractId-timestamp)
                $parts = explode('-', $txnRef);
                $contractId = $parts[0] ?? $txnRef;
                $contractDurationId = 1; // Default value
                
                // Try to get the contract_duration_id from the contract
                $contract = Contract::find($contractId);
                if ($contract && $contract->signatures && $contract->signatures->count() > 0) {
                    $signature = $contract->signatures->first();
                    // Find the duration by label
                    $duration = Duration::where('label', $signature->duration)->first();
                    if ($duration) {
                        $contractDuration = ContractDuration::where('service_id', $contract->service_id)
                            ->where('duration_id', $duration->id)
                            ->first();
                        
                        if ($contractDuration) {
                            $contractDurationId = $contractDuration->id;
                        }
                    }
                }
                
                Log::info('VNPay IPN - Extracted Data:', [
                    'contract_id' => $contractId, 
                    'txnRef' => $txnRef,
                    'contract_duration_id' => $contractDurationId
                ]);

                // Kiểm tra xem giao dịch đã được xử lý trước đó chưa
                $existingPayment = Payment::where('transaction_id', $request->vnp_TransactionNo)
                                        ->where('status', 'Hoàn Thành')
                                        ->first();

                // Nếu giao dịch đã được xử lý, không xử lý lại
                if ($existingPayment) {
                    Log::info("VNPay IPN - Payment already processed for TransactionNo: {$request->vnp_TransactionNo}");
                    return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                        ->header('Content-Type', 'application/json');
                }

                // Lưu thanh toán thành công
                try {
                    $contract = Contract::find($contractId);
                    if ($contract) {
                        // Tìm signature gần nhất của hợp đồng này
                        $signature = Signature::where('contract_id', $contractId)->latest()->first();
                        
                        if ($signature) {
                            // Lấy duration từ signature
                            $durationLabel = $signature->duration;
                            
                            // Tìm duration_id
                            $duration = Duration::where('label', $durationLabel)->first();
                            
                            if ($duration) {
                                // Tìm contract_duration_id
                                $contractDuration = ContractDuration::where('service_id', $contract->service_id)
                                                                  ->where('duration_id', $duration->id)
                                                                  ->first();
                                
                                if ($contractDuration) {
                                    // Lưu thanh toán thành công với contract_duration_id
                                    Payment::create([
                                        'contract_id' => $contractId,
                                        'contract_duration_id' => $contractDuration->id,
                                        'amount' => ($request->vnp_Amount ?? 0) / 100,
                                        'date' => now(),
                                        'method' => 'VNPay',
                                        'transaction_id' => $request->vnp_TransactionNo ?? null,
                                        'order_id' => $txnRef,
                                        'payment_type' => $request->vnp_CardType ?? null, 
                                        'payment_response' => json_encode($request->all()),
                                        'status' => 'Hoàn Thành'
                                    ]);
                                    
                                    // Cập nhật trạng thái hợp đồng
                                    $contract->status = 'Hoạt động';
                                    $contract->save();
                                    
                                    // Tự động áp dụng chữ ký của công ty
                                    $this->addCompanySignature($contractId);
                                    
                                    Log::info("VNPay IPN - Contract status updated for Contract ID: $contractId", [
                                        'old_status' => $contract->getOriginal('status'), 
                                        'new_status' => 'Hoạt động'
                                    ]);
                                }
                            }
                        }
                    }
                    
                    Log::info("VNPay IPN - Payment record created successfully");
                } catch (Exception $e) {
                    Log::error("VNPay IPN - Error creating payment record: " . $e->getMessage());
                    return response('{"RspCode":"99","Message":"Error creating payment"}', 200)
                        ->header('Content-Type', 'application/json');
                }
                
                Log::info("VNPay IPN - Payment SUCCESSFUL for Contract ID: $contractId");
                return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                    ->header('Content-Type', 'application/json');
            } else {
                // Lưu thông tin thanh toán thất bại
                $txnRef = $request->vnp_TxnRef;
                $parts = explode('-', $txnRef);
                $contractId = $parts[0] ?? $txnRef;
                
                $contract = Contract::find($contractId);
                if ($contract) {
                    $signature = Signature::where('contract_id', $contractId)->latest()->first();
                    
                    if ($signature && $signature->contract_duration_id) {
                        Payment::create([
                            'contract_id' => $contractId,
                            'contract_duration_id' => $signature->contract_duration_id,
                            'amount' => ($request->vnp_Amount ?? 0) / 100,
                            'date' => now(),
                            'method' => 'VNPay',
                            'transaction_id' => $request->vnp_TransactionNo ?? null,
                            'order_id' => $txnRef,
                            'payment_type' => $request->vnp_CardType ?? null,
                            'payment_response' => json_encode($request->all()),
                            'status' => 'Thất Bại',
                            'error_message' => 'Mã lỗi: ' . $request->vnp_ResponseCode,
                        ]);
                    }
                }
                
                Log::warning("VNPay IPN - Payment FAILED for Contract ID: $contractId", $request->all());
                return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                    ->header('Content-Type', 'application/json');
            }
        } catch (Exception $e) {
            Log::error('VNPay IPN - Exception:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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
            
            // Kiểm tra nếu công ty đã ký
            if ($signature->admin_signature_data) {
                return true;
            }
            
            // Lấy thông tin chữ ký công ty từ cấu hình
            $companySignature = config('app.company_signature');
            
            // Cập nhật thông tin chữ ký công ty
            $signature->update([
                'admin_name' => $companySignature['name'],
                'admin_position' => $companySignature['position'],
                'admin_signature_data' => $companySignature['signature_data'] ?? asset('images/company-signature.png'),
                'admin_signature_image' => $companySignature['signature_data'] ?? asset('images/company-signature.png'),
                'admin_signed_at' => now(),
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error("VNPay - Error adding company signature: " . $e->getMessage());
            return false;
        }
    }
}
