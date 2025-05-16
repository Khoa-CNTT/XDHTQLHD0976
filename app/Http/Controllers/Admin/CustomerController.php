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
    
    // Xử lý điều kiện tìm kiếm bắt buộc
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        
        // Kiểm tra nếu từ khóa có dấu "@" -> Tìm kiếm email
        if (strpos($search, '@') !== false) {
            $query->where('email', 'like', "%{$search}%");
        } else {
            // Tách từ khóa thành mảng các từ
            $searchTerms = explode(' ', $search);
            
            $query->where(function($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where('name', 'like', "%{$term}%")
                      ->orWhere('phone', 'like', "%{$term}%");
                }
            });
        }
    } else {
        // Nếu không có từ khóa tìm kiếm, có thể trả về thông báo lỗi hoặc chỉ cho phép tìm kiếm với điều kiện khác
        // Ví dụ: return back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
    }

    // Lọc theo trạng thái
    if ($request->has('status') && !empty($request->status)) {
        $query->where('status', $request->status);
    }

    // Lấy danh sách khách hàng
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