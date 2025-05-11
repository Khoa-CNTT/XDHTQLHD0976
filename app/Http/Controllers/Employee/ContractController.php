<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        // Khởi tạo query để lấy danh sách hợp đồng với các quan hệ
        $query = Contract::with('service', 'customer');
    
        // Tìm kiếm theo mã hợp đồng
        if ($request->has('contract_number') && !empty($request->contract_number)) {
            $query->where('contract_number', 'like', '%' . $request->contract_number . '%');
        }
        
        // Lọc theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Lọc theo service
        if ($request->has('service_id') && !empty($request->service_id)) {
            $query->where('service_id', $request->service_id);
        }
        
        // Lọc theo ngày bắt đầu
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }
        
        // Lọc theo ngày kết thúc
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('end_date', '<=', $request->date_to);
        }
        
        // Tìm kiếm theo tên khách hàng
        if ($request->has('customer_name') && !empty($request->customer_name)) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }
        
        // Phân trang kết quả
        $contracts = $query->paginate(10);
        
        // Lấy danh sách dịch vụ cho dropdown filter
        $services = Service::all();
        
        // Trả về view hiển thị danh sách hợp đồng
        return view('admin.contracts.index', compact('contracts', 'services'));
    }

    public function show($id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $contract = Contract::with('customer', 'service')->findOrFail($id);
        return view('admin.contracts.show', compact('contract'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $contract = Contract::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Chờ xử lý,Hoạt động,Hoàn thành,Đã huỷ',
        ]);

        $contract->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.contracts.index')->with('success', 'Trạng thái hợp đồng đã được cập nhật.');
    }

    public function markAsComplete($id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $contract = Contract::findOrFail($id);

        if ($contract->status !== 'Hoàn thành') {
            $contract->status = 'Hoàn thành';
            $contract->save();

            return redirect()->route('admin.contracts.index')->with('success', 'Hợp đồng đã được đánh dấu là hoàn thành.');
        }

        return redirect()->route('admin.contracts.index')->with('warning', 'Hợp đồng đã ở trạng thái hoàn thành.');
    }

    public function confirmCancel($id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $contract = Contract::findOrFail($id);
        if ($contract->status !== 'Yêu cầu huỷ') {
            return redirect()->back()->with('error', 'Hợp đồng không ở trạng thái yêu cầu huỷ.');
        }
        $contract->status = 'Đã huỷ';
        $contract->save();
        return redirect()->back()->with('success', 'Hợp đồng đã được xác nhận huỷ.');
    }
} 