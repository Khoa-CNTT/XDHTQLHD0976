<?php

return [
     'tmn_code'      => env('VNPAY_TMN_CODE'),
    'hash_secret'   => env('VNPAY_SECURE_SECRET'),
    'url'           => env('VNPAY_PAYMENT_URL'),
    'ipn_url'       => env('VNPAY_IPN_URL'),
    'return_url'    => env('VNPAY_RETURN_URL'),
    'vnp_version'   => '2.1.0',
    'vnp_command'   => 'pay',
    'vnp_currcode'  => 'VND',
    'vnp_locale'    => 'vn',
    'vnp_ordertype' => 'billpayment',
    
];

