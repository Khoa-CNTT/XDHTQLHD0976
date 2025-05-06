<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractAmendmentController extends Controller
{
    public function index($contractId)
    {
        $contract = Contract::with('amendments')->findOrFail($contractId);
        return view('customer.contracts.amendments.index', compact('contract'));
    }
}