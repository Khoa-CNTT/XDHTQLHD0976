<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSignatureController extends Controller
{
    public function showForm()
    {
        $signaturePath = null;
        if (Storage::disk('local')->exists('company_signature_path.txt')) {
            $path = trim(Storage::disk('local')->get('company_signature_path.txt'));
            if ($path && !str_starts_with($path, 'data:image')) {
                $signaturePath = asset('storage/' . $path);
            } else {
                $signaturePath = $path;
            }
        }
        return view('admin.signatures.form', compact('signaturePath'));
    }
public function save(Request $request)
{
    // Tên file chữ ký cố định
    $canvasFilePath = 'signatures/admin_signature.png';
    $uploadFilePath = null;

    // Nếu là vẽ trên canvas (base64)
    if ($request->filled('signature_pad_data')) {
        // Xóa chữ ký cũ nếu có
        if (Storage::disk('public')->exists($canvasFilePath)) {
            Storage::disk('public')->delete($canvasFilePath);
        }

        $base64 = $request->input('signature_pad_data');
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
        Storage::disk('public')->put($canvasFilePath, $image);
    }
    // Nếu là upload file hình ảnh
    elseif ($request->hasFile('signature')) {
        $file = $request->file('signature');
        $extension = $file->getClientOriginalExtension();
        $uploadFilePath = 'signatures/admin_signature.' . $extension;

        // Xóa các bản chữ ký cũ với định dạng có thể khác
        $existingFiles = Storage::disk('public')->files('signatures');
        foreach ($existingFiles as $filePath) {
            if (str_starts_with($filePath, 'signatures/admin_signature')) {
                Storage::disk('public')->delete($filePath);
            }
        }

        // Lưu file mới
        $file->storeAs('signatures', 'admin_signature.' . $extension, 'public');
    }
    else {
        return back()->with('error', 'Bạn phải chọn hoặc vẽ chữ ký.');
    }

    return back()->with('success', 'Chữ ký đã được lưu thành công.');
}

    }