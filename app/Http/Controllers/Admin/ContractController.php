<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('customer', 'service')->paginate(10);
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
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'contract_number' => 'required|unique:contracts',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,active,completed,cancelled',
            'total_price' => 'required|numeric'
        ]);
        Contract::create($data);
        return redirect()->route('admin.contracts.index')->with('success', 'Tạo hợp đồng thành công!');
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
            'customer_id' => 'required',
            'service_id' => 'required',
            'contract_number' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => 'required',
            'total_price' => 'required'
        ]);
        $contract->update($data);
        return redirect()->route('admin.contracts.index')->with('success', 'Cập nhật hợp đồng thành công!');
    }

    public function destroy($id)
    {
        Contract::destroy($id);
        return redirect()->back()->with('success', 'Xoá hợp đồng thành công!');
    }
}
