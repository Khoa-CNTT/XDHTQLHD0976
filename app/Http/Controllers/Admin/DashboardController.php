<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            $title = 'Admin Dashboard';
        } elseif ($role === 'employee') {
            $title = 'Employee Dashboard';
        }

        return view('admin.dashboard', compact('title'));
    }
}
