<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
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
        $contracts = Contract::with('service')->get(); // Lấy tất cả hợp đồng
        // $contracts = Contract::where('service_id', 1)->with('service')->get(); // Lọc theo service_id
        return view('customer.dashboard', compact('isLoggedIn', 'user','contracts'));
    }
}
