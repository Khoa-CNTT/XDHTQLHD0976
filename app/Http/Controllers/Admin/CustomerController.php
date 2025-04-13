<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function ban($id)
    {
        $customer = User::findOrFail($id);
        $customer->update(['status' => 'banned']);
        return redirect()->route('admin.customers.index')->with('success', 'Khóa tài khoản khách hàng thành công!');
    }

public function unban($id)
{
    $customer = User::findOrFail($id);
    $customer->update(['status' => 'active']);
    return redirect()->route('admin.customers.index')->with('success', 'Mở khóa tài khoản khách hàng thành công!');
}

    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Xóa khách hàng thành công!');
    }
}