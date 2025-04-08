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
}
