<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');
        
        // Xử lý tìm kiếm
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Lọc theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $customers = $query->paginate(10);
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