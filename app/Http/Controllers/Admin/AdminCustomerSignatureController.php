<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Signature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCustomerSignatureController extends Controller
{
    /**
     * Hiển thị danh sách chữ ký của khách hàng
     */
    public function index()
    {
        $customers = Customer::with(['user', 'contracts.signatures'])->get();
        return view('admin.customer_signatures.index', compact('customers'));
    }

    /**
     * Hiển thị form xem và quản lý chữ ký của một khách hàng cụ thể
     */
    public function show($customerId)
    {
        $customer = Customer::with(['user', 'contracts.signatures'])->findOrFail($customerId);
        return view('admin.customer_signatures.show', compact('customer'));
    }

    /**
     * Xóa chữ ký của khách hàng
     */
    public function delete($signatureId)
    {
        $signature = Signature::findOrFail($signatureId);
        
        // Xóa ảnh chữ ký từ storage nếu có
        if ($signature->signature_image && !str_starts_with($signature->signature_image, 'data:image')) {
            Storage::disk('public')->delete('signatures/' . $signature->signature_image);
        }
        
        // Xóa bản ghi chữ ký
        $signature->delete();
        
        return redirect()->back()->with('success', 'Chữ ký khách hàng đã được xóa thành công.');
    }
    
    /**
     * Tải lên chữ ký mới cho khách hàng
     */
    public function upload(Request $request, $customerId)
    {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'signature_image' => 'required|image|max:2048'
        ]);
        
        $customer = Customer::with('user')->findOrFail($customerId);
        
        // Lưu ảnh chữ ký
        $file = $request->file('signature_image');
        $filename = 'customer_' . $customerId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('signatures', $filename, 'public');
        
        // Tạo hoặc cập nhật bản ghi chữ ký
        Signature::updateOrCreate(
            ['contract_id' => $request->contract_id],
            [
                'customer_name' => $customer->user->name,
                'customer_email' => $customer->user->email,
                'signature_image' => $filename,
                'signature_data' => 'admin_uploaded',
                'status' => 'Đã ký',
                'signed_at' => now()
            ]
        );
        
        return redirect()->back()->with('success', 'Chữ ký khách hàng đã được tải lên thành công.');
    }
} 