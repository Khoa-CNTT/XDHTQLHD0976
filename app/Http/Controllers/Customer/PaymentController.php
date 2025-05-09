<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Hiển thị danh sách thanh toán của khách hàng
     */
    public function index()
    {
        $customerId = Auth::user()->customer->id;
        $payments = Payment::whereHas('contract', function($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->orderBy('date', 'desc')->paginate(10);
        
        return view('customer.payments.index', compact('payments'));
    }

    /**
     * Hiển thị chi tiết một thanh toán
     */
    public function show($id)
    {
        $customerId = Auth::user()->customer->id;
        $payment = Payment::with(['contract.service'])
            ->whereHas('contract', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })
            ->findOrFail($id);
            
        return view('customer.payments.show', compact('payment'));
    }

    /**
   
     */
    public function downloadReceipt($id)
    {
        $customerId = Auth::user()->customer->id;
        $payment = Payment::with(['contract.service', 'contract.customer.user'])
            ->whereHas('contract', function($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })
            ->findOrFail($id);
        
        // Kiểm tra xem thanh toán có thành công hay không
        if ($payment->status !== 'Hoàn Thành') {
            return redirect()->back()->with('error', 'Chỉ có thể tải hóa đơn cho các thanh toán đã hoàn thành.');
        }
        
        // Tạo PDF
        try {
            $data = [
                'payment' => $payment,
                'date' => date('d/m/Y'),
            ];
            
            $pdf = Pdf::loadView('customer.payments.receipt', $data);
            return $pdf->download('hoa-don-' . $payment->transaction_id . '.pdf');
        } catch (\Exception $e) {
            // Nếu có lỗi, ghi log và trả về view HTML
            \Illuminate\Support\Facades\Log::error('PDF generation error: ' . $e->getMessage());
            return view('customer.payments.receipt', compact('payment'));
        }
    }
}
