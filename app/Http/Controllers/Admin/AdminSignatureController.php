<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminSignatureController extends Controller
{
    /**
     * Hiển thị form để admin tải lên chữ ký tay.
     */
   public function showSignatureForm()
{
    $signaturePath = null;

    if (Storage::disk('local')->exists('company_signature_path.txt')) {
        $signaturePath = Storage::get('company_signature_path.txt');
        if (!str_starts_with($signaturePath, 'data:image')) {
            $signaturePath = asset('storage/' . $signaturePath);
        }
    }

    return view('admin.signatures.form', compact('signaturePath'));
}

    /**
     * Lưu chữ ký tay của admin.
     */
   
public function saveSignature(Request $request)
{
      Log::info('DỮ LIỆU GỬI VỀ:', $request->all()); 
    $request->validate([
        'signature' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        'signature_pad_data' => 'nullable|string',
    ]);

    $path = null;

    // Bước 1: Xác định chữ ký cũ nếu có
    $currentSignaturePath = null;
    if (Storage::disk('local')->exists('company_signature_path.txt')) {
        $currentSignaturePath = Storage::get('company_signature_path.txt');
    }

    // Bước 2: Upload ảnh chữ ký hoặc lưu từ signature pad
    if ($request->hasFile('signature')) {
        $path = $request->file('signature')->store('signatures', 'public');
    } elseif ($request->filled('signature_pad_data')) {
        $signatureData = $request->input('signature_pad_data');
        $image = str_replace('data:image/png;base64,', '', $signatureData);
        $image = str_replace(' ', '+', $image);
        $decodedImage = base64_decode($image);

        $fileName = 'signature_' . time() . '.png';
        Storage::disk('public')->put('signatures/' . $fileName, $decodedImage);

        $path = 'signatures/' . $fileName;
    }

    // Nếu không có gì để lưu
    if (!$path) {
        return redirect()->back()->with('error', 'Vui lòng tải lên hoặc vẽ chữ ký.');
    }

    // Bước 3: Xóa chữ ký cũ nếu là file ảnh (không phải base64)
    if ($currentSignaturePath && !str_starts_with($currentSignaturePath, 'data:image')) {
        Storage::disk('public')->delete($currentSignaturePath);
    }

    // Bước 4: Ghi đường dẫn mới vào file config
    Storage::disk('local')->put('company_signature_path.txt', $path);

    return redirect()->route('admin.signature.form')->with('success', 'Chữ ký đã được lưu thành công.');
}















}