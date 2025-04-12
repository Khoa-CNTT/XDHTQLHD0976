<?php

return [
    'required' => 'Trường :attribute là bắt buộc.',
    'email' => ':attribute phải là một email hợp lệ.',
    'min' => [
        'numeric' => 'Trường :attribute phải ít nhất là :min.',
        'file' => 'Trường :attribute phải ít nhất là :min kilobytes.',
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
        'array' => 'Trường :attribute phải có ít nhất :min phần tử.',
    ],
    'max' => [
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'file' => 'Trường :attribute không được lớn hơn :max kilobytes.',
        'string' => 'Trường :attribute không được lớn hơn :max ký tự.',
        'array' => 'Trường :attribute không được có nhiều hơn :max phần tử.',
    ], 
    'name_warning' => 'Tên phải là tên đầy đủ hoặc tên ngắn, không chứa ký tự đặc biệt!',
    'email_warning' => 'Email phải có đuôi @gmail và không chứa ký tự đặc biệt!',
    'phone_warning' => 'Số điện thoại phải là số và có 10 ký tự!',
    'tax_code_warning' => 'Mã số thuế phải là số và có độ dài 10 hoặc 13 ký tự!',
    'password_warning' => 'Mật khẩu phải có chữ in hoa, chữ số và ký tự đặc biệt!',







    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'active_url' => 'Trường :attribute không phải là một URL hợp lệ.',
    'after' => 'Trường :attribute phải là một ngày sau :date.',
    'after_or_equal' => 'Trường :attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => 'Trường :attribute chỉ được chứa các chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ được chứa các chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => 'Trường :attribute chỉ được chứa các chữ cái và số.',
    'array' => 'Trường :attribute phải là một mảng.',
    'before' => 'Trường :attribute phải là một ngày trước :date.',
    'before_or_equal' => 'Trường :attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => 'Trường :attribute phải nằm giữa :min và :max.',
        'file' => 'Trường :attribute phải có kích thước giữa :min và :max kilobytes.',
        'string' => 'Trường :attribute phải có độ dài giữa :min và :max ký tự.',
        'array' => 'Trường :attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean' => 'Trường :attribute phải là true hoặc false.',
    'confirmed' => 'Mật khẩu không khớp nhau.',
    'date' => 'Trường :attribute không phải là một ngày hợp lệ.',
    'date_equals' => 'Trường :attribute phải là ngày bằng :date.',
    'date_format' => 'Trường :attribute phải khớp với định dạng ngày :format.',
    'different' => 'Trường :attribute và :other phải khác nhau.',
    'digits' => 'Trường :attribute phải là :digits chữ số.',
    'digits_between' => 'Trường :attribute phải có từ :min đến :max chữ số.',
    'dimensions' => 'Trường :attribute có kích thước ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có giá trị trùng lặp.',
    'ends_with' => 'Trường :attribute phải kết thúc bằng một trong các giá trị sau: :values.',
    'exists' => 'Trường :attribute đã chọn không hợp lệ.',
    'file' => 'Trường :attribute phải là một tệp.',
    'filled' => 'Trường :attribute phải có giá trị.',
    'gt' => [
        'numeric' => 'Trường :attribute phải lớn hơn :value.',
        'file' => 'Trường :attribute phải có kích thước lớn hơn :value kilobytes.',
        'string' => 'Trường :attribute phải có độ dài lớn hơn :value ký tự.',
        'array' => 'Trường :attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :value.',
        'file' => 'Trường :attribute phải có kích thước lớn hơn hoặc bằng :value kilobytes.',
        'string' => 'Trường :attribute phải có độ dài lớn hơn hoặc bằng :value ký tự.',
        'array' => 'Trường :attribute phải có ít nhất :value phần tử.',
    ],
    'image' => 'Trường :attribute phải là một hình ảnh.',
    'in' => 'Trường :attribute đã chọn không hợp lệ.',
    'in_array' => 'Trường :attribute không tồn tại trong :other.',
    'integer' => 'Trường :attribute phải là một số nguyên.',
    'ip' => 'Trường :attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => 'Trường :attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => 'Trường :attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => 'Trường :attribute phải là một chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => 'Trường :attribute phải nhỏ hơn :value.',
        'file' => 'Trường :attribute phải có kích thước nhỏ hơn :value kilobytes.',
        'string' => 'Trường :attribute phải có độ dài nhỏ hơn :value ký tự.',
        'array' => 'Trường :attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => 'Trường :attribute phải có kích thước nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => 'Trường :attribute phải có độ dài nhỏ hơn hoặc bằng :value ký tự.',
        'array' => 'Trường :attribute không được có nhiều hơn :value phần tử.',
    ],
    
    'mimes' => 'Trường :attribute phải là một tệp có loại: :values.',
    'mimetypes' => 'Trường :attribute phải là một tệp có loại: :values.',
    
    'not_in' => 'Trường :attribute đã chọn không hợp lệ.',
    'not_regex' => 'Định dạng của trường :attribute không hợp lệ.',
    'numeric' => 'Trường :attribute phải là một số.',
    'password' => [
        'letters' => 'Trường :attribute phải có ít nhất một chữ cái.',
        'mixed' => 'Trường :attribute phải có ít nhất một chữ cái viết hoa và một chữ cái viết thường.',
        'numbers' => 'Trường :attribute phải có ít nhất một chữ số.',
        'symbols' => 'Trường :attribute phải có ít nhất một ký tự đặc biệt.',
        'confirmed' => 'Mật khẩu không khớp nhau.',
    ],
    'present' => 'Trường :attribute phải xuất hiện.',
    'regex' => 'Định dạng của trường :attribute không hợp lệ.',

    'required_if' => 'Trường :attribute là bắt buộc khi :other là :value.',
    'required_unless' => 'Trường :attribute là bắt buộc trừ khi :other là :value.',
    'required_with' => 'Trường :attribute là bắt buộc khi :values có mặt.',
    'required_with_all' => 'Trường :attribute là bắt buộc khi :values có mặt.',
    'required_without' => 'Trường :attribute là bắt buộc khi :values không có mặt.',
    'required_without_all' => 'Trường :attribute là bắt buộc khi không có trường nào trong :values có mặt.',
    'same' => 'Trường :attribute và :other phải giống nhau.',
    'size' => [
        'numeric' => 'Trường :attribute phải là :size.',
        'file' => 'Trường :attribute phải có kích thước :size kilobytes.',
        'string' => 'Trường :attribute phải có độ dài :size ký tự.',
        'array' => 'Trường :attribute phải chứa :size phần tử.',
    ],
    'starts_with' => 'Trường :attribute phải bắt đầu với một trong các giá trị sau: :values.',
    'string' => 'Trường :attribute phải là một chuỗi ký tự.',
    'timezone' => 'Trường :attribute phải là một vùng thời gian hợp lệ.',
    'unique' => 'Trường :attribute đã tồn tại.',
    'uploaded' => 'Trường :attribute không thể tải lên.',
    'url' => 'Định dạng của trường :attribute không hợp lệ.',
    'uuid' => 'Trường :attribute phải là một UUID hợp lệ.',



    
];

