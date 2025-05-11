<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các thanh toán
     */
    public function index()
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $payments = Payment::with(['contract.customer.user', 'contract.service'])
                  ->orderBy('date', 'desc')
                  ->paginate(10);
        
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Hiển thị chi tiết một thanh toán
     */
    public function show($id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $payment = Payment::with(['contract.customer.user', 'contract.service'])
                 ->findOrFail($id);
        
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Cập nhật thông tin thanh toán
     */
    public function update(Request $request, $id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $request->validate([
            'status' => 'required|in:Hoàn Thành,Đang Xử Lý,Thất Bại,Đang Đợi',
            'notes' => 'nullable|string|max:255',
        ]);
        
        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->notes = $request->notes;
        $payment->save();
        
        // Cập nhật trạng thái hợp đồng nếu thanh toán hoàn thành
        if ($request->status === 'Hoàn Thành' && $payment->contract) {
            $payment->contract->payment_status = 'Đã Thanh Toán';
            $payment->contract->save();
        }
        
        return redirect()->route('admin.payments.show', $payment->id)
                        ->with('success', 'Cập nhật thanh toán thành công!');
    }
} 