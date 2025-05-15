<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Contract;
use App\Models\ContractDocument;

class ContractUploadController extends Controller
{
    /**
     * Hiển thị danh sách tài liệu của hợp đồng
     */
    public function index($contractId)
    {
        $contract = Contract::with('documents')->findOrFail($contractId);

        // Kiểm tra quyền truy cập hợp đồng
        if ($contract->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Bạn không có quyền truy cập tài liệu của hợp đồng này.');
        }

        return view('customer.contracts.documents.index', compact('contract'));
    }

    /**
     * Hiển thị form tải tài liệu lên
     */
    public function create($contractId)
    {
        $contract = Contract::findOrFail($contractId);

        // Kiểm tra quyền truy cập hợp đồng
        if ($contract->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Bạn không có quyền truy cập hợp đồng này.');
        }

        return view('customer.contracts.documents.create', compact('contract'));
    }

    /**
     * Xử lý lưu tài liệu được tải lên
     */
    public function store(Request $request, $contractId)
    {
        $contract = Contract::findOrFail($contractId);

        // Kiểm tra quyền truy cập hợp đồng
        if ($contract->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Bạn không có quyền truy cập hợp đồng này.');
        }

        // Validate dữ liệu đầu vào
        $request->validate([
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Lưu file vào thư mục 'contract_documents' trên disk 'public'
        $filePath = $request->file('file')->store('contract_documents', 'public');

        // Lưu thông tin tài liệu vào CSDL
        ContractDocument::create([
            'contract_id' => $contractId,
            'document_name' => $request->document_name,
            'file_path' => $filePath,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('customer.contracts.documents.index', $contractId)
            ->with('success', 'Tài liệu đã được tải lên thành công.');
    }

    /**
     * Xoá tài liệu hợp đồng
     */
    public function destroy($contractId, $documentId)
    {
        $document = ContractDocument::findOrFail($documentId);

        // Kiểm tra quyền truy cập tài liệu
        if ($document->contract->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Bạn không có quyền xóa tài liệu này.');
        }

        // Xoá file khỏi hệ thống
        Storage::disk('public')->delete($document->file_path);

        // Xoá bản ghi tài liệu
        $document->delete();

        return redirect()->route('customer.contracts.documents.index', $contractId)
            ->with('success', 'Tài liệu đã được xóa thành công.');
    }

    /**
     * Tải tài liệu lên từ form không kiểm tra quyền
     * (dùng cho admin hoặc upload từ nơi khác)
     */
    public function uploadDocument(Request $request, $contractId)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'document_name' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Lưu file
        $filePath = $request->file('file')->store('contract_documents', 'public');

        // Tạo bản ghi tài liệu
        ContractDocument::create([
            'contract_id' => $contractId,
            'document_name' => $request->document_name,
            'file_path' => $filePath,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('admin.contracts.show', $contractId)
            ->with('success', 'Tài liệu đã được tải lên.');
    }
}
