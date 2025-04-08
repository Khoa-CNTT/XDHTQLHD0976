<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
use App\Models\Service;
class DashboardController extends Controller
{
    // public function index()
    // {
    //     return view('customer.dashboard'); // Trả về view customer/dashboard.blade.php
    // }

    public function index()
    {
        $isLoggedIn = Auth::check();
        $user = $isLoggedIn ? Auth::user() : null;
    
        // Lấy danh sách dịch vụ
        $services = Service::select('id', 'service_name', 'description', 'service_type', 'price')->paginate(10); // Phân trang
    
        return view('customer.dashboard', compact('isLoggedIn', 'user', 'services'));
    }
    public function show($id)
    {
        $contract = Contract::with('service')->findOrFail($id);
        return view('customer.contracts.show', compact('contract'));
    }
    public function filter($type)
    {
        // Nếu chọn "Tất Cả", lấy tất cả hợp đồng
        if ($type === 'Tất Cả') {
            $contracts = Contract::with('service')->get();
        } else {
            // Lấy danh sách hợp đồng theo loại dịch vụ
            $contracts = Contract::with('service')->whereHas('service', function ($query) use ($type) {
                $query->where('service_type', $type);
            })->get();
        }

        // Trả về view với danh sách hợp đồng
        return view('customer.contracts.index', compact('contracts', 'type'));
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm hợp đồng theo số hợp đồng hoặc tên dịch vụ
        $contracts = Contract::with('service')
            ->where('contract_number', 'LIKE', "%{$query}%")
            ->orWhereHas('service', function ($q) use ($query) {
                $q->where('service_name', 'LIKE', "%{$query}%");
            })
            ->get();

        return view('customer.contracts.index', compact('contracts'));
    }
}
