<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct()
{
    // Chỉ áp dụng middleware cho các phương thức cần thiết
    $this->middleware('auth')->except(['show', 'filter', 'search', 'index']);
}
public function filter($type)
{
    if ($type === 'Tất Cả Dịch Vụ') {
        $services = Service::orderByDesc('is_hot')
            ->orderByDesc('created_at')
            ->paginate(9);
    } else {
        $services = Service::where('service_type', $type)
            ->orderByDesc('is_hot')
            ->orderByDesc('created_at')
            ->paginate(9);
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
public function index()
{
    $services = Service::orderByDesc('is_hot')
        ->orderByDesc('created_at')
        ->paginate(10);

    return view('customer.services.index', compact('services'));
}


public function search(Request $request)
{
    $query = $request->input('query');

    $services = Service::query()
        ->when($query, function ($q) use ($query) {
            $q->where('service_name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhere('service_type', 'LIKE', "%{$query}%")
              ->orWhere('price', '=', $query);
        })
        ->orderByDesc('is_hot')
        ->orderByDesc('created_at')
        ->paginate(9);

    $type = $query ? "Kết quả tìm kiếm cho: '{$query}'" : 'Tất Cả Dịch Vụ';

    return view('customer.services.index', compact('services', 'query', 'type'));
}

}