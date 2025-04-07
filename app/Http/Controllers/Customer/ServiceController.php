<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function filter($type)
    {
        // Lấy danh sách dịch vụ theo kiểu
        $services = Service::where('service_type', $type)->get();

        // Trả về view với danh sách dịch vụ
        return view('customer.services.index', compact('services', 'type'));
    }
}