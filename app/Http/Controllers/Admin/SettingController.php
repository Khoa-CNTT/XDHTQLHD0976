<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'general');
        $settings = [
            'system_name' => config('app.name'),
            'contact_email' => config('mail.from.address'),
            'logo' => asset('storage/logos/logo1.png'),
            'smtp_host' => config('mail.mailers.smtp.host'),
            'smtp_port' => config('mail.mailers.smtp.port'),
        ];

        $backups = [['file' => 'backup_20240514.sql', 'created_at' => '2025-05-14 10:00']];
        $roles = [['name' => 'Admin', 'permissions' => ['Quản lý user', 'Quản lý hợp đồng']]];
        $logs = [['user' => 'admin', 'action' => 'Cập nhật cài đặt', 'time' => '2025-05-14 09:00']];

        return view('admin.settings', compact('settings', 'tab', 'backups', 'roles', 'logs'));
    }

    public function update(Request $request)
{
    $request->validate([
        'system_name' => 'required|string|max:255',
        'contact_email' => 'required|email',
        'logo' => 'nullable|image|max:2048',
        'smtp_host' => 'required|string',
        'smtp_port' => 'required|numeric',
    ]);

    // Xử lý upload logo nếu có
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('logos', 'public');
        config(['app.logo' => 'storage/' . $logoPath]); // Cập nhật cấu hình tạm thời
        // Lưu đường dẫn logo vào file config để hiển thị
        file_put_contents(config_path('app.php'), preg_replace(
            "/'logo' => '.*'/",
            "'logo' => 'storage/$logoPath'",
            file_get_contents(config_path('app.php'))
        ));
    }

    config(['app.name' => $request->input('system_name')]);
    config(['mail.from.address' => $request->input('contact_email')]);

    return redirect()->back()->with('success', 'Cập nhật cài đặt thành công!');
}

}
