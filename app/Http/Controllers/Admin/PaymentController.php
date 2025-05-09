<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các thanh toán
     */
    public function index()
    {
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
        $payment = Payment::with(['contract.customer.user', 'contract.service'])
                 ->findOrFail($id);
        
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Tạo báo cáo thanh toán
     */
    public function createReport(Request $request)
    {
        $startDate = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : null;
        $endDate = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null;
        
        $query = Payment::with(['contract.customer.user', 'contract.service']);
        
        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $payments = $query->orderBy('date', 'desc')->get();
        
        // Tính tổng số tiền
        $totalAmount = $payments->where('status', 'Hoàn Thành')->sum('amount');
        
        return view('admin.payments.report', compact('payments', 'totalAmount', 'startDate', 'endDate'));
    }

    /**
     * Xuất báo cáo PDF
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : null;
        $endDate = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null;
        
        $query = Payment::with(['contract.customer.user', 'contract.service']);
        
        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $payments = $query->orderBy('date', 'desc')->get();
        $totalAmount = $payments->where('status', 'Hoàn Thành')->sum('amount');
        
        $data = [
            'payments' => $payments,
            'totalAmount' => $totalAmount,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'date' => date('d/m/Y'),
        ];
        
        $pdf = Pdf::loadView('admin.payments.pdf', $data);
        return $pdf->download('bao-cao-thanh-toan-' . date('d-m-Y') . '.pdf');
    }

    /**
     * Cập nhật thông tin thanh toán
     */
    public function update(Request $request, $id)
    {
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