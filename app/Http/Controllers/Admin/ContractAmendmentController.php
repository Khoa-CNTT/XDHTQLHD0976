<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractAmendment;
use Illuminate\Http\Request;

class ContractAmendmentController extends Controller
{
  
    public function index($contractId)
    {
        $contract = Contract::with('amendments')->findOrFail($contractId);

        return view('admin.contracts.admendments.index', compact('contract'));
    }
    public function create($contractId)
    {
        $contract = Contract::findOrFail($contractId);

        return view('admin.contracts.admendments.create', compact('contract'));
    }

   
    public function store(Request $request, $contractId)
    {
        $contract = Contract::findOrFail($contractId); 

        $validated = $request->validate([
            'amendment_reason' => 'required|string|max:255',
            'changes_made' => 'required|string',
            'effective_date' => 'required|date|after_or_equal:today',
        ]);

        $contract->amendments()->create($validated); 

        return redirect()
            ->route('admin.contracts.admendments.index', $contractId)
            ->with('success', 'Phụ lục hợp đồng đã được thêm thành công.');
    }
}
