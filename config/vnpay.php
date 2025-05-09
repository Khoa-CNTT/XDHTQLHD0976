<?php

return [
    // TMN Code cung cấp bởi VNPay, lấy từ Merchant Dashboard
    'tmn_code' => env('VNPAY_TMN_CODE', ''),
    
    // Hash secret cung cấp bởi VNPay để tạo/kiểm tra chữ ký
    'hash_secret' => env('VNPAY_SECURE_SECRET', ''),
    
    // URL cổng thanh toán (sandbox hoặc production)
    'url' => env('VNPAY_PAYMENT_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    
    // URL nhận IPN notification từ VNPay
    'ipn_url' => env('VNPAY_IPN_URL', ''),
    
    // URL redirect sau khi thanh toán
    'return_url' => env('VNPAY_RETURN_URL', 'customer.contracts.show'),
    
    // Loại tiền tệ (VND)
    'vnp_currcode' => 'VND',
    
    // Ngôn ngữ giao diện (vn/en)
    'vnp_locale' => 'vn',
    
    // Phiên bản API
    'vnp_version' => '2.1.0',
    
    // Lệnh thanh toán
    'vnp_command' => 'pay',
    
    // Loại đơn hàng
    'vnp_ordertype' => 'billpayment',
];
