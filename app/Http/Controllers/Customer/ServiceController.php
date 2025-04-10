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
            $services = Service::select('id', 'service_name', 'description', 'service_type', 'price', 'created_by', 'created_at', 'is_hot')->paginate(9); // Phân trang
        } else {
            // Lấy dịch vụ theo loại
            $services = Service::select('id', 'service_name', 'description', 'service_type', 'price', 'created_by', 'created_at', 'is_hot')
                ->where('service_type', $type)
                ->paginate(9); // Phân trang
        }
    
        return view('customer.services.index', compact('services', 'type'));
    }
    public function show($id)
{
    $service = Service::findOrFail($id); // Lấy dịch vụ theo ID
    return view('customer.services.show', compact('service'));
}


public function search(Request $request)
{
    $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ request

    $services = Service::query()
        ->when($query, function ($q) use ($query) {
            $q->where('service_name', 'LIKE', "% {$query}%")
              ->orWhere('description', 'LIKE', "% {$query}%")
              ->orWhere('service_type', 'LIKE', "% {$query}%")
              ->orWhere('price', '=', $query); // Tìm kiếm chính xác trong cột 'price'
        })
        ->paginate(9); // Phân trang kết quả

    $type = 'Tất Cả'; // Giá trị mặc định cho loại dịch vụ

    return view('customer.services.index', compact('services', 'query', 'type'));
}
}