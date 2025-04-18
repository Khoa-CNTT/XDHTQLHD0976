<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee; 
class ServiceController extends Controller
{
    // Hiển thị danh sách các dịch vụ
    public function index()
    {
        $services = Service::with('employee')->get(); // Lấy tất cả dịch vụ và thông tin người tạo
        return view('admin.services.index', compact('services'));
    }

    // Hiển thị form tạo mới dịch vụ
    public function create()
    {
        return view('admin.services.create');
    }

        // Lưu dịch vụ mới vào cơ sở dữ liệu
        public function store(Request $request)
        {
            // Làm sạch và định dạng giá
            $rawPrice = $request->input('price');
            $cleanPrice = str_replace(['.', ','], '', $rawPrice);
            $formattedPrice = number_format((float)$cleanPrice, 2, '.', '');
            $request->merge(['price' => $formattedPrice]);
        
            // Validate
            $data = $request->validate([
                'service_name' => 'required|string|max:255|unique:services',
                'description' => 'required|string',
                'content' => 'required|string',
                'service_type' => 'required|string',
                'price' => 'numeric|max:99999999.99',
            ], [
                'service_name.unique' => 'Tên dịch vụ đã tồn tại.',
            ]);
        
            // Gán thêm các field phụ
            $employeeId = optional(Auth::user()->employee)->id;
        
            if (!$employeeId) {
                abort(403, 'Không thể tạo dịch vụ vì tài khoản này không có thông tin nhân viên.');
            }
        
            $data['created_by'] = $employeeId;
            $data['is_hot'] = $request->has('is_hot') ? 1 : 0;
        
            // Lưu
            Service::create($data);
        
            return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được thêm thành công!');
        }
        

    // Hiển thị chi tiết một dịch vụ
    public function show($id)
    {
        $service = Service::findOrFail($id); // Lấy dịch vụ theo id
        return view('admin.services.show', compact('service'));
    }

    // Hiển thị form chỉnh sửa dịch vụ
    public function edit($id)
    {
        $service = Service::findOrFail($id); // Lấy dịch vụ theo id
        return view('admin.services.edit', compact('service'));
    }

    // Cập nhật thông tin dịch vụ
    public function update(Request $request, $id)
{
    $service = Service::findOrFail($id);

    // Làm sạch giá trị giá trước khi validate
    $rawPrice = $request->input('price');
    $cleanPrice = str_replace(['.', ','], '', $rawPrice);
    $formattedPrice = number_format((float)$cleanPrice, 2, '.', '');

    // Merge lại giá đã xử lý để validation không báo lỗi
    $request->merge(['price' => $formattedPrice]);

    // Validate dữ liệu
    $data = $request->validate([
        'service_name' => 'required|string|max:255|unique:services,service_name,' . $id,
        'description' => 'required|string',
        'content' => 'required|string',
        'service_type' => 'required|string',
        'price' => 'required|numeric|min:0',

    ], [
        'service_name.unique' => 'Tên dịch vụ đã tồn tại.',
    ]);
    $data['is_hot'] = $request->has('is_hot') ? 1 : 0;
    // Không cần cập nhật created_by khi update
    $service->update($data);

    return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
}

    // Xoá một dịch vụ
    public function destroy($id)
    {
        Service::destroy($id); // Xoá dịch vụ
        return redirect()->back()->with('success', 'Xoá dịch vụ thành công!');
    }

// Tìm kiếm dịch vụ

    public function search(Request $request)
{
    $query = $request->input('query');
    $services = Service::where('service_name', 'LIKE', "%{$query}%")->get();
    return view('admin.services.index', compact('services'));
}

}