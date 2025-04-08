<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function filter($type)
    {
        if ($type === 'Tất Cả') {
            // Lấy tất cả dịch vụ
            $services = Service::select('id', 'service_name', 'description', 'service_type', 'price')->paginate(10); // Phân trang
        } else {
            // Lấy dịch vụ theo loại
            $services = Service::select('id', 'service_name', 'description', 'service_type', 'price')
                ->where('service_type', $type)
                ->paginate(10); // Phân trang
        }
    
        return view('customer.services.index', compact('services', 'type'));
    }
    public function show($id)
{
    $service = Service::findOrFail($id); // Lấy dịch vụ theo ID
    return view('customer.services.show', compact('service'));
}
}