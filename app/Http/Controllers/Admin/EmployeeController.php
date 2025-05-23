<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{public function index(Request $request)
{
    // Khởi tạo query builder
    $query = Employee::query()->with('user');
    
    // Kiểm tra nếu có từ khóa tìm kiếm và không rỗng
    if ($request->filled('search')) {
        $search = trim($request->search);
        
        // Tìm kiếm trong bảng 'user' (tên, email)
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });

        // Tìm kiếm trong các trường khác của bảng Employee (position, department)
        $query->orWhere('position', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%");
    }

    // Nếu có lọc theo phòng ban (department)
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Lấy danh sách nhân viên theo thứ tự mới nhất và phân trang
    $employees = $query->latest()->paginate(10);
    
    // Lấy danh sách phòng ban để hiển thị trong dropdown
    $departments = Employee::select('department')->distinct()->get();
    
    return view('admin.employees.index', compact('employees', 'departments'));
}


    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        // Đảm bảo rằng mọi dấu phân cách hàng nghìn đều được loại bỏ
        $salary = str_replace([',', '.'], '', $request->salary);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'identity_card' => 'required|string|max:12|unique:users',
            'dob' => 'required|date',
            'password' => 'required|string|min:8',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hired_date' => 'required|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        
        // Thêm validation thủ công cho salary
        if (!is_numeric($salary) || $salary < 0) {
            return redirect()->back()->with('error', 'Lương phải là số dương')->withInput();
        }

        DB::beginTransaction();
        try {
            // Tạo tài khoản người dùng
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'identity_card' => $request->identity_card,
                'dob' => $request->dob,
                'password' => Hash::make($request->password),
                'role' => 'employee',
                'status' => 'active',
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            // Tạo hồ sơ nhân viên
            Employee::create([
                'user_id' => $user->id,
                'position' => $request->position,
                'department' => $request->department,
                'salary' => $salary, // Sử dụng giá trị đã được xử lý
                'hired_date' => $request->hired_date,
            ]);

            DB::commit();
            return redirect()->route('admin.employees.index')->with('success', 'Thêm nhân viên thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        
        // Đảm bảo rằng mọi dấu phân cách hàng nghìn đều được loại bỏ
        $salary = str_replace([',', '.'], '', $request->salary);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->user->id,
            'identity_card' => 'required|string|max:12|unique:users,identity_card,' . $employee->user->id,
            'dob' => 'required|date',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'hired_date' => 'required|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        
        // Thêm validation thủ công cho salary
        if (!is_numeric($salary) || $salary < 0) {
            return redirect()->back()->with('error', 'Lương phải là số dương')->withInput();
        }

        DB::beginTransaction();
        try {
            // Cập nhật thông tin người dùng
            $employee->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'identity_card' => $request->identity_card,
                'dob' => $request->dob,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            // Cập nhật mật khẩu nếu được cung cấp
            if ($request->filled('password')) {
                $employee->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Cập nhật thông tin nhân viên
            $employee->update([
                'position' => $request->position,
                'department' => $request->department,
                'salary' => $salary, // Sử dụng giá trị đã được xử lý
                'hired_date' => $request->hired_date,
            ]);

            DB::commit();
            return redirect()->route('admin.employees.index')->with('success', 'Cập nhật nhân viên thành công!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        
        // Không xóa tài khoản user, chỉ xóa thông tin nhân viên
        $employee->delete();
        
        return redirect()->route('admin.employees.index')->with('success', 'Xóa nhân viên thành công!');
    }
}