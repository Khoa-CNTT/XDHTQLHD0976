<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ContractDocument;
use App\Models\Contract;

class ContractUploadController extends Controller
{
    public function uploadDocument(Request $request, $contractId)
{
    // Validate the request
    $request->validate([
        'document_name' => 'required|string',
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    // Store the uploaded file in the 'contract_documents' folder within the 'public' disk
    $filePath = $request->file('file')->store('contract_documents', 'public');

    // Create a new contract document record in the database
    ContractDocument::create([
        'contract_id' => $contractId,
        'document_name' => $request->document_name,
        'file_path' => $filePath,
        'uploaded_by' => Auth::id(), // Get the ID of the currently authenticated user
    ]);

    // Redirect back to the contract details page with a success message
    return redirect()->route('admin.contracts.show', $contractId)
        ->with('success', 'Tài liệu đã được tải lên.');
}
public function index($contractId)
{
    $contract = Contract::with('documents')->findOrFail($contractId);

    // Kiểm tra quyền truy cập hợp đồng
    if ($contract->customer_id !== Auth::user()->customer->id) {
        abort(403, 'Bạn không có quyền truy cập tài liệu của hợp đồng này.');
    }

    return view('customer.contracts.documents.index', compact('contract'));
}
public function create($contractId)
    {
        $contract = Contract::findOrFail($contractId);

        // Kiểm tra quyền truy cập hợp đồng
        if ($contract->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Bạn không có quyền truy cập hợp đồng này.');
        }

        return view('customer.contracts.documents.create', compact('contract'));
    }
    public function store(Request $request, $contractId)
    {
        $contract = Contract::findOrFail($contractId);

        // Kiểm tra quyền truy cập hợp đồng
        if ($contract->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Bạn không có quyền truy cập hợp đồng này.');
        }

        $request->validate([
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $request->file('file')->store('contract_documents', 'public');

        ContractDocument::create([
            'contract_id' => $contractId,
            'document_name' => $request->document_name,
            'file_path' => $filePath,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('customer.contracts.documents.index', $contractId)
            ->with('success', 'Tài liệu đã được tải lên thành công.');
    }
    public function destroy($contractId, $documentId)
    {
        $document = ContractDocument::findOrFail($documentId);

        // Kiểm tra quyền truy cập tài liệu
        if ($document->contract->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Bạn không có quyền xóa tài liệu này.');
        }
        // Xóa file khỏi hệ thống
        Storage::disk('public')->delete($document->file_path);

        // Xóa bản ghi trong cơ sở dữ liệu
        $document->delete();

        return redirect()->route('customer.contracts.documents.index', $contractId)
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }
}
