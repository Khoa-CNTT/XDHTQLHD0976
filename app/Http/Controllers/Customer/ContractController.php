<?php

namespace App\Http\Controllers\Customer;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('service')->get();
        return view('customer.contracts.index', compact('contracts'));
    }

    public function show($id)
    {
        $contract = Contract::with('service')->findOrFail($id);
        return view('customer.contracts.show', compact('contract'));
    }
}
