<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;


class ContractController extends Controller
{
  






    public function index()
    {
        // Lấy danh sách tất cả hợp đồng
        $contracts = Contract::with('service', 'customer')->paginate(10);
    
        // Trả về view hiển thị danh sách hợp đồng
        return view('admin.contracts.index', compact('contracts'));
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
        return view('admin.contracts.show', compact('contract'));
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
        'status' => 'required|in:Chờ xử lý,Hoạt động,Hoàn thành,Đã huỷ',
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



    public function sign(Request $request, $id)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'signature_data' => 'required', // Dữ liệu chữ ký
    ]);

    // Lưu chữ ký
    \App\Models\Signature::create([
        'contract_id' => $id,
        'customer_name' => $validated['customer_name'],
        'customer_email' => $validated['customer_email'],
        'signature_data' => $validated['signature_data'],
    ]);

    return redirect()->route('customer.dashboard')->with('success', 'Hợp đồng đã được ký thành công!');
}
public function updateStatus(Request $request, $id)
{
    $contract = Contract::findOrFail($id);

    $request->validate([
        'status' => 'required|in:Chờ xử lý,Hoạt động,Hoàn thành,Đã huỷ',
    ]);

    $contract->update([
        'status' => $request->input('status'),
    ]);

    return redirect()->route('admin.contracts.index')->with('success', 'Trạng thái hợp đồng đã được cập nhật.');
}
}
