<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractAmendment;
use App\Models\ContractDocument;
use App\Models\Service;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;



class ContractController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query để lấy danh sách hợp đồng với các quan hệ
        $query = Contract::with('service', 'customer');
    
       if ($request->filled('contract_number')) {
    $query->where('contract_number', 'like', '%' . trim($request->contract_number) . '%');
}

if ($request->filled('status')) {
    $query->where('status', $request->status);
}

if ($request->filled('service_id')) {
    $query->where('service_id', $request->service_id);
}

if ($request->filled('date_from')) {
    $query->whereDate('start_date', '>=', $request->date_from);
}

if ($request->filled('date_to')) {
    $query->whereDate('end_date', '<=', $request->date_to);
}

if ($request->filled('customer_name')) {
    $query->whereHas('customer', function($q) use ($request) {
        $q->where('name', 'like', '%' . trim($request->customer_name) . '%');
    });
}
        
        // Phân trang kết quả
        $contracts = $query->paginate(10);
        
        // Lấy danh sách dịch vụ cho dropdown filter
        $services = Service::all();
        
        // Trả về view hiển thị danh sách hợp đồng
        return view('admin.contracts.index', compact('contracts', 'services'));
    }

    public function create()
    {
        $customers = \App\Models\Customer::all();
        $services = \App\Models\Service::all();
        return view('admin.contracts.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id' => 'required|exists:services,id',
            'contract_number' => 'required|unique:contracts,contract_number',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric|min:0',
        ]);
             // Loại bỏ dấu phẩy khỏi giá trị price
  
        $validatedData['total_price'] = str_replace(',', '', $request->total_price);

        // Lưu hợp đồng
        Contract::create(array_merge($validatedData, [
            'signed_document' => null, // Để trống, khách hàng sẽ ký sau
        ]));

        return redirect()->route('admin.contracts.index')->with('success', 'Hợp đồng đã được tạo thành công.');
    }


    public function show($id)
{
    $contract = Contract::with('customer', 'service')->findOrFail($id);

  
    $isPaid = \App\Models\Payment::where('contract_id', $contract->id)
        ->where('status', 'Hoàn Thành')
        ->exists();

    return view('admin.contracts.show', compact('contract', 'isPaid'));
}

    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        $customers = \App\Models\Customer::all();
        $services = \App\Models\Service::all();
        return view('admin.contracts.edit', compact('contract', 'customers', 'services'));
    }
    public function update(Request $request, $id)
{
    $contract = Contract::findOrFail($id);
    
    $data = $request->validate([
        'service_id' => 'required',
        'contract_number' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:Chờ xử lý,Hoàn thành,Đã huỷ',
        'total_price' => 'required|numeric|min:0',
    ]);
    
  
    $contract->update($data);

    if ($data['status'] === 'Hoàn thành') {
        foreach ($contract->signatures as $signature) {
            $signature->update([
                'status' => 'Đã ký', 
            ]);
        }
    }

    return redirect()->route('admin.contracts.index')->with('success', 'Cập nhật hợp đồng thành công!');
}

    public function destroy($id)
    {
        Contract::destroy($id);
        return redirect()->back()->with('success', 'Xoá hợp đồng thành công!');
    }



public function updateStatus(Request $request, $id)
{
    $contract = Contract::findOrFail($id);

    $request->validate([
        'status' => 'required|in:Chờ xử lý,Hoàn thành,Đã huỷ',
    ]);

    $contract->update([
        'status' => $request->input('status'),
    ]);

    return redirect()->route('admin.contracts.index')->with('success', 'Trạng thái hợp đồng đã được cập nhật.');
}

public function confirmCancel($id)
{
    $contract = Contract::findOrFail($id);
    if ($contract->status !== 'Yêu cầu huỷ') {
        return redirect()->back()->with('error', 'Hợp đồng không ở trạng thái yêu cầu huỷ.');
    }
    $contract->status = 'Đã huỷ';
    $contract->save();
    return redirect()->back()->with('success', 'Hợp đồng đã được xác nhận huỷ.');
}



// Phương thức tạo PDF hợp đồng với chữ ký của cả hai bên
public function generateContractPdf($id)
{
    $contract = Contract::with(['service', 'customer.user', 'signatures'])->findOrFail($id);
    
    if ($contract->signatures->isEmpty()) {
        return redirect()->route('admin.contracts.show', $id)
            ->with('error', 'Hợp đồng chưa có chữ ký.');
    }
    
    $signature = $contract->signatures->first();
    
    // Kiểm tra nếu cả hai bên đã ký
    if (!$signature->isFullySigned()) {
        return redirect()->route('admin.contracts.show', $id)
            ->with('error', 'Hợp đồng chưa được ký đầy đủ bởi cả hai bên.');
    }
    
    $pdf = Pdf::loadView('contracts.pdf', compact('contract', 'signature'));
    
    return $pdf->download('hop-dong-' . $contract->contract_number . '.pdf');
}




}
