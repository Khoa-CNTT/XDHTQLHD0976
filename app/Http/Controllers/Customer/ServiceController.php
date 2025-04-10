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
    // Kiểm tra nếu type là "Tất Cả Dịch Vụ"
    if ($type === 'Tất Cả Dịch Vụ') {
        $services = Service::paginate(9); // Lấy tất cả dịch vụ và phân trang
    } else {
        // Lọc theo loại dịch vụ và phân trang
        $services = Service::where('service_type', $type)->paginate(9);
    }

    return view('customer.services.index', [
        'services' => $services,
        'type' => $type,
    ]);
}
    public function show($id)
{
    $service = Service::findOrFail($id); // Lấy dịch vụ theo ID
    return view('customer.services.show', compact('service'));
}


public function search(Request $request)
{
    $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ request

    // Tìm kiếm dịch vụ theo từ khóa
    $services = Service::query()
        ->when($query, function ($q) use ($query) {
            $q->where('service_name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhere('service_type', 'LIKE', "%{$query}%")
              ->orWhere('price', '=', $query); // Tìm kiếm chính xác trong cột 'price'
        })
        ->paginate(9); // Phân trang kết quả

    // Nếu có từ khóa tìm kiếm, hiển thị tiêu đề phù hợp
    $type = $query ? "Kết quả tìm kiếm cho: '{$query}'" : 'Tất Cả Dịch Vụ';

    return view('customer.services.index', compact('services', 'query', 'type'));
}
}