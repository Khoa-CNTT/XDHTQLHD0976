<?php

namespace App\Http\Controllers\Customer;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function index() {
        $contracts = Contract::with('customer', 'service')
            ->paginate(10)
            ->where('customer_id', Auth::user()->customer->id)
            ->orderByDesc('start_date')
            ->get();
        return view('customer.contracts.index', compact('contracts'));
    }

    public function show($id) {
        $contract = Contract::with('service')->where('customer_id', Auth::user()->customer->id)->findOrFail($id);
        return view('customer.contracts.show', compact('contract'));
    }
}
