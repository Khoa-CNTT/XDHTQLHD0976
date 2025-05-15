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
    $canvasFilePath = 'signatures/admin_signature.png';
    $uploadFilePath = null;

    try {
        // Nếu là chữ ký vẽ từ canvas
        if ($request->filled('signature_pad_data')) {
            if (Storage::disk('public')->exists($canvasFilePath)) {
                Storage::disk('public')->delete($canvasFilePath);
            }

            $base64 = $request->input('signature_pad_data');
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64));
            Storage::disk('public')->put($canvasFilePath, $image);

            $message = 'Chữ ký đã được lưu thành công.';
        }
        // Nếu là upload ảnh từ input file
        elseif ($request->hasFile('signature')) {
            $file = $request->file('signature');
            $extension = $file->getClientOriginalExtension();
            $uploadFilePath = 'signatures/admin_signature.' . $extension;

            // Xóa chữ ký cũ (mọi định dạng)
            $existingFiles = Storage::disk('public')->files('signatures');
            foreach ($existingFiles as $filePath) {
                if (str_starts_with($filePath, 'signatures/admin_signature')) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            // Lưu file mới
            $file->storeAs('signatures', 'admin_signature.' . $extension, 'public');
            $message = 'Chữ ký đã được lưu thành công.';
        } else {
            $message = 'Bạn phải chọn hoặc vẽ chữ ký.';

            // Trả về phù hợp với loại request
            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $message])
                : back()->with('error', $message);
        }

        // Trả kết quả thành công
        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $message])
            : back()->with('success', $message);
    } catch (\Exception $e) {
        $errorMsg = 'Đã xảy ra lỗi khi lưu chữ ký.';

        return $request->expectsJson()
            ? response()->json(['success' => false, 'message' => $errorMsg])
            : back()->with('error', $errorMsg);
    }
}



    }