<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    // Hiển thị danh sách loại dịch vụ
    public function index()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.categories.index', compact('categories'));
    }

    // Lưu loại dịch vụ mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories',
            'description' => 'nullable|string',
        ]);

        ServiceCategory::create($request->all());

        return redirect()->route('admin.service-categories.index')->with('success', 'Danh mục dịch vụ đã được thêm.');
    }

    // Hiển thị form chỉnh sửa loại dịch vụ
    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('admin.services.categories.edit', compact('category'));
    }

    // Cập nhật loại dịch vụ
    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.service-categories.index')->with('success', 'Cập nhật danh mục dịch vụ thành công!');
    }

    // Xóa loại dịch vụ
    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.service-categories.index')->with('success', 'Xóa danh mục dịch vụ thành công!');
    }
}