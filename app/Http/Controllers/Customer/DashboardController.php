<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('customer.dashboard', compact('isLoggedIn', 'user'));
    }
}
