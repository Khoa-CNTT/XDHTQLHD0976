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
        $services = Service::select('id', 'image','service_name', 'description', 'service_type', 'price', 'created_by', 'created_at', 'is_hot')
        ->orderByDesc('is_hot')           // Ưu tiên dịch vụ hot
        ->orderByDesc('created_at')       // Sau đó đến mới nhất
        ->paginate(9);                    // Phân trang
        return view('customer.dashboard', compact('isLoggedIn', 'user', 'services'));
    }
    public function show($id)
    {
        $contract = Contract::with('service')->findOrFail($id);
        return view('customer.contracts.show', compact('contract'));
    }
}
