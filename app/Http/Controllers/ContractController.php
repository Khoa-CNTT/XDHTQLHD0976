<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('customer', 'service')->get();
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services = Service::all();
        return view('contracts.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'contract_number' => 'required|unique:contracts',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric|min:0',
        ]);

        Contract::create($request->all());

        return redirect()->route('contracts.index')->with('success', 'Hợp đồng đã được tạo.');
    }

    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $customers = Customer::all();
        $services = Service::all();
        return view('contracts.edit', compact('contract', 'customers', 'services'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric|min:0',
        ]);

        $contract->update($request->all());

        return redirect()->route('contracts.index')->with('success', 'Hợp đồng đã được cập nhật.');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Hợp đồng đã bị xóa.');
    }
}
