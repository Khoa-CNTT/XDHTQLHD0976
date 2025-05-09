<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Contract;
use App\Models\Payment;
use Exception;

class VNPayController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
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
            
            // Force set hash secret to make sure it matches
            $vnp_HashSecret = env('VNPAY_SECURE_SECRET', 'OFQFTLGKA26BTWGQ8IS94H4XVM480AVE');
            
            $vnp_TxnRef = $request->contract_id; 
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
            
            $vnp_HashSecret = config('vnpay.hash_secret');
            Log::info('VNPay - Hash Secret Config:', ['hash_secret' => substr($vnp_HashSecret, 0, 3) . '...' . substr($vnp_HashSecret, -3)]);
            
            // Force set hash secret to make sure it matches
            $vnp_HashSecret = env('VNPAY_SECURE_SECRET', 'OFQFTLGKA26BTWGQ8IS94H4XVM480AVE');
            Log::info('VNPay - Using Hash Secret:', ['hash_secret' => substr($vnp_HashSecret, 0, 3) . '...' . substr($vnp_HashSecret, -3)]);
            
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

            $txnRef = $request->vnp_TxnRef ?? 'unknown';

            // Kiểm tra xem giao dịch đã được xử lý trước đó chưa
            $existingPayment = Payment::where('transaction_id', $request->vnp_TransactionNo)
                                    ->where('status', 'Hoàn Thành')
                                    ->first();

            // Nếu giao dịch đã được xử lý, không xử lý lại
            if ($existingPayment) {
                Log::info("VNPay - Payment already processed for TransactionNo: {$request->vnp_TransactionNo}");
                return redirect()->route('customer.contracts.show', ['id' => $txnRef])
                                ->with('success', 'Thanh toán đã được xử lý thành công!');
            }

            // Kiểm tra trạng thái giao dịch
            if ($request->vnp_ResponseCode == '00' && $request->vnp_TransactionStatus == '00') {
                // Lưu thanh toán thành công
                Payment::create([
                    'contract_id' => $txnRef,
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
                $contract = Contract::find($txnRef);
                if ($contract) {
                    $contract->status = 'Hoàn thành';
                    $contract->save();
                    
                    Log::info("VNPay - Contract status updated for TxnRef: $txnRef", [
                        'old_status' => $contract->getOriginal('status'), 
                        'new_status' => 'Hoàn thành'
                    ]);
                } else {
                    Log::error("VNPay - Contract not found for TxnRef: $txnRef");
                }
                
                Log::info("VNPay - Payment SUCCESSFUL for TxnRef: $txnRef");
                return redirect()->route('customer.contracts.show', ['id' => $txnRef])
                                ->with('success', 'Thanh toán thành công! Hợp đồng đã được cập nhật trạng thái.');
            } else {
                Log::warning("VNPay - Payment FAILED for TxnRef: $txnRef, ResponseCode: " . $request->vnp_ResponseCode);
                return redirect()->route('customer.contracts.show', ['id' => $txnRef])
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
            
            $vnp_HashSecret = config('vnpay.hash_secret');
            Log::info('VNPay IPN - Hash Secret Config:', ['hash_secret' => substr($vnp_HashSecret, 0, 3) . '...' . substr($vnp_HashSecret, -3)]);
            
            // Force set hash secret to make sure it matches
            $vnp_HashSecret = env('VNPAY_SECURE_SECRET', 'OFQFTLGKA26BTWGQ8IS94H4XVM480AVE');
            Log::info('VNPay IPN - Using Hash Secret:', ['hash_secret' => substr($vnp_HashSecret, 0, 3) . '...' . substr($vnp_HashSecret, -3)]);
            
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

            // Kiểm tra trạng thái giao dịch
            if ($request->vnp_ResponseCode == '00' && $request->vnp_TransactionStatus == '00') {
                $txnRef = $request->vnp_TxnRef;
                
                // Lưu thanh toán thành công
                Payment::create([
                    'contract_id' => $txnRef,
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
                $contract = Contract::find($txnRef);
                if ($contract) {
                    $contract->status = 'Hoàn thành';
                    $contract->save();
                    
                    Log::info("VNPay IPN - Contract status updated for TxnRef: $txnRef", [
                        'old_status' => $contract->getOriginal('status'), 
                        'new_status' => 'Hoàn thành'
                    ]);
                } else {
                    Log::error("VNPay IPN - Contract not found for TxnRef: $txnRef");
                }
                
                Log::info("VNPay IPN - Payment SUCCESSFUL for TxnRef: $txnRef");
                return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                    ->header('Content-Type', 'application/json');
            } else {
                // Lưu thông tin thanh toán thất bại
                Payment::create([
                    'contract_id' => $request->vnp_TxnRef,
                    'amount' => ($request->vnp_Amount ?? 0) / 100,
                    'date' => now(),
                    'method' => 'VNPay',
                    'transaction_id' => $request->vnp_TransactionNo ?? null,
                    'order_id' => $request->vnp_TxnRef,
                    'payment_type' => $request->vnp_CardType ?? null,
                    'payment_response' => json_encode($request->all()),
                    'status' => 'Thất Bại',
                    'error_message' => 'Mã lỗi: ' . $request->vnp_ResponseCode,
                ]);
                
                Log::warning('VNPay IPN: Thanh toán thất bại', $request->all());
                return response('{"RspCode":"00","Message":"Confirm Success"}', 200)
                    ->header('Content-Type', 'application/json');
            }
        } catch (Exception $e) {
            Log::error('VNPay IPN - Exception:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response('{"RspCode":"99","Message":"Unknown error"}', 200)
                ->header('Content-Type', 'application/json');
        }
    }
}
