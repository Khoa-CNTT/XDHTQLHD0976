<?php

namespace App\Http\Controllers\Customer;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Signature;

class ContractController extends Controller
{
    public function index()
    {
        try {
            $customer = Auth::user()->customer;

            $contracts = Contract::with(['service' => function($query) {
                 
                    $query->withDefault([
                        'service_name' => 'Dịch vụ không tồn tại'
                    ]);
                }])
                ->where('customer_id', $customer->id)
                ->get();

            return view('customer.contracts.index', compact('contracts'));
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi tải danh sách hợp đồng: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $contract = Contract::with(['customer.user', 'service' => function($query) {
              
                $query->withDefault([
                    'service_name' => 'Dịch vụ không tồn tại'
                ]);
            }, 'signatures', 'payments'])
            ->findOrFail($id);

            return view('customer.contracts.show', compact('contract'));
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi tải thông tin hợp đồng: ' . $e->getMessage());
        }
    }

    public function requestCancel($id)
    {
        $contract = Contract::findOrFail($id);
        $customer = Auth::user()->customer;
        if ($contract->customer_id !== $customer->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền huỷ hợp đồng này.');
        }
        if ($contract->status === 'Đã huỷ') {
            return redirect()->back()->with('error', 'Hợp đồng đã bị huỷ trước đó.');
        }
        if ($contract->status === 'Yêu cầu huỷ') {
            return redirect()->back()->with('error', 'Bạn đã gửi yêu cầu huỷ hợp đồng này.');
        }
        $contract->status = 'Yêu cầu huỷ';
        $contract->save();
        return redirect()->back()->with('success', 'Yêu cầu huỷ hợp đồng đã được gửi. Quản trị viên sẽ xác nhận!');
    }

    
    public function downloadPdf($id)
{
    $contract = Contract::with(['service', 'signatures'])->findOrFail($id);

    // Kiểm tra nếu trạng thái hợp đồng là "Hoàn thành"
    if ($contract->status !== 'Hoàn thành') {
        return redirect()->route('customer.contracts.show', $id)
            ->with('error', 'Hợp đồng chưa hoàn thành, không thể tải xuống.');
    }

    // Kiểm tra nếu cả hai bên đã ký
    if ($contract->signatures->isEmpty() || !$contract->signatures->first()->admin_signature_data) {
        return redirect()->route('customer.contracts.show', $id)
            ->with('error', 'Hợp đồng chưa được ký đầy đủ.');
    }

    // Tạo file PDF
    $pdf = pdf::loadView('contracts.pdf', compact('contract'));

    // Tải file PDF
    return $pdf->download('hop-dong-' . $contract->contract_number . '.pdf');
}
public function generateContractPdf($id)
{
    $contract = Contract::with(['service', 'customer.user', 'signatures'])->findOrFail($id);

    if ($contract->signatures->isEmpty()) {
        return redirect()->route('admin.contracts.show', $id)
            ->with('error', 'Hợp đồng chưa có chữ ký của khách hàng.');
    }

    $signature = $contract->signatures->first();

    // Kiểm tra nếu trạng thái hợp đồng là "Hoàn thành"
    if ($contract->status !== 'Hoàn thành') {
        return redirect()->route('admin.contracts.show', $id)
            ->with('error', 'Hợp đồng chưa hoàn thành.');
    }

    // Lấy chữ ký admin từ cấu hình
    $adminSignaturePath = config('app.company_signature');

    // Tạo file PDF
    $pdf = pdf::loadView('contracts.pdf', compact('contract', 'signature', 'adminSignaturePath'));

    return $pdf->download('hop-dong-' . $contract->contract_number . '.pdf');
}
}






    
