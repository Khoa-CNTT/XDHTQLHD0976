<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('contract')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $contracts = Contract::all();
        return view('payments.create', compact('contracts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'method' => 'required|string',
            'status' => 'required|string',
        ]);

        Payment::create($request->all());

        return redirect()->route('payments.index')->with('success', 'Thanh toán đã được ghi nhận.');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $contracts = Contract::all();
        return view('payments.edit', compact('payment', 'contracts'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'method' => 'required|string',
            'status' => 'required|string',
        ]);

        $payment->update($request->all());

        return redirect()->route('payments.index')->with('success', 'Thanh toán đã được cập nhật.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Thanh toán đã bị xóa.');
    }
}
