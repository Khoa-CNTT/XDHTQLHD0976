<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $query = Service::with('employee', 'category');

        // Tìm kiếm theo tên dịch vụ hoặc mô tả
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Lọc theo danh mục
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo giá (từ - đến)
        if ($request->has('price_from') && !empty($request->price_from)) {
            $query->where('price', '>=', str_replace('.', '', $request->price_from));
        }

        if ($request->has('price_to') && !empty($request->price_to)) {
            $query->where('price', '<=', str_replace('.', '', $request->price_to));
        }

        // Lấy dịch vụ theo điều kiện đã lọc
        $services = $query->paginate(10);
        
        // Lấy danh sách danh mục cho dropdown
        $categories = ServiceCategory::all();
        
        // Lấy danh sách nhân viên cho dropdown
        $employees = Employee::with('user')->get();

        return view('admin.services.index', compact('services', 'categories', 'employees'));
    }

    public function create()
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

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

        $data['created_by'] = Auth::user()->employee->id;
        $data['is_hot'] = $request->has('is_hot') ? 1 : 0;

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được thêm thành công!');
    }

    public function show($id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $service = Service::with('category', 'employee')->findOrFail($id);  
        return view('admin.services.show', compact('service'));
    }
    
    public function edit($id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        $service = Service::with('category')->findOrFail($id);
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Kiểm tra quyền
        if (!Auth::user()->isEmployee()) {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

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
} 