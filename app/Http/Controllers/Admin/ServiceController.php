<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee; 
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceCategory;

class ServiceController extends Controller

{
    
    // Hiển thị danh sách các dịch vụ
    public function index(Request $request)
{
    $query = Service::with('employee', 'category');

    // Nếu có chọn lọc theo danh mục
    if ($request->has('category_id') && $request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    // Lọc theo loại dịch vụ (Phần mềm, Phần cứng, Nhà mạng, v.v.)
    if ($request->has('service_type') && $request->service_type) {
        $query->where('service_type', $request->service_type);
    }

    // Lấy dịch vụ theo điều kiện đã lọc
    $services = $query->get();

    return view('admin.services.index', compact('services'));
}
    // Hiển thị form tạo mới dịch vụ
    public function create()
{
    $categories = ServiceCategory::all();
    return view('admin.services.create', compact('categories'));
}

        // Lưu dịch vụ mới vào cơ sở dữ liệu
        public function store(Request $request)
{
    $request->validate([
        'service_name' => 'required|string|max:255|unique:services',
        'description' => 'required|string',
        'content' => 'required|string',
        'price' => 'required|string', 
        'category_id' => 'required|exists:service_categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
    ]);

    $data = $request->all();

  
    $data['price'] = str_replace('.', '', $data['price']);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('services', 'public');
        $data['image'] = $imagePath;
    }

    $data['created_by'] = optional(Auth::user()->employee)->id;
    $data['is_hot'] = $request->has('is_hot') ? 1 : 0;

    Service::create($data);

    return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được thêm thành công!');
}
        

    // Hiển thị chi tiết một dịch vụ
    public function show($id)
    {
        $service = Service::with('category', 'employee')->findOrFail($id);  
        return view('admin.services.show', compact('service'));
    }
    
    // Hiển thị form chỉnh sửa dịch vụ
    public function edit($id)
    {
        $service = Service::with('category')->findOrFail($id);
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
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
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:service_categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',

    ], [
        'service_name.unique' => 'Tên dịch vụ đã tồn tại.',
    ]);
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu có
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        // Lưu ảnh mới
        $imagePath = $request->file('image')->store('services', 'public');
        $data['image'] = $imagePath;
    } else {
        // Giữ lại ảnh cũ
        $data['image'] = $service->image;
    }
    $data['is_hot'] = $request->has('is_hot') ? 1 : 0;
    $service->update($data);

    return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
}

   
    public function destroy($id)
    {
        Service::destroy($id);
        return redirect()->back()->with('success', 'Xoá dịch vụ thành công!');
    }


    public function search(Request $request)
{
    $query = $request->input('query');
    $services = Service::where('service_name', 'LIKE', "%{$query}%")->get();
    return view('admin.services.index', compact('services'));
}

}