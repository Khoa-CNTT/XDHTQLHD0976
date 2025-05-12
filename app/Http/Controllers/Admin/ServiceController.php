<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee; 
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceCategory;
use App\Models\ContractDuration;
use App\Models\Duration;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    // Hiển thị danh sách các dịch vụ
    public function index(Request $request)
    {
        $query = Service::with(['employee', 'category', 'contractDurations']);

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

        // Lọc theo người tạo
        if ($request->has('created_by') && !empty($request->created_by)) {
            $query->where('created_by', $request->created_by);
        }

        // Lọc theo dịch vụ nổi bật
        if ($request->has('is_hot') && $request->is_hot) {
            $query->where('is_hot', 1);
        }

        // Lấy dịch vụ theo điều kiện đã lọc
        $services = $query->paginate(10);
        
        // Lấy danh sách danh mục và nhân viên cho dropdown
        $categories = ServiceCategory::all();
        $employees = Employee::all();

        return view('admin.services.index', compact('services', 'categories', 'employees'));
    }
    
    // Hiển thị form tạo mới dịch vụ
    public function create()
    {
        $categories = ServiceCategory::all();
        $durations = Duration::orderBy('months')->get();
        return view('admin.services.create', compact('categories', 'durations'));
    }

    // Lưu dịch vụ mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255|unique:services',
            'description' => 'required|string',
            'content' => 'required|string',
            
            'category_id' => 'required|exists:service_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'duration_prices' => 'nullable|array',
            'duration_prices.*' => 'nullable|string',
        ], [
            'service_name.unique' => 'Tên dịch vụ đã tồn tại.',
            'image.image' => 'Ảnh không hợp lệ.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, svg hoặc jfif.',
            'image.max' => 'Ảnh không được lớn hơn 2MB.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'description.required' => 'Mô tả là bắt buộc.',
            'content.required' => 'Nội dung là bắt buộc.',
            'service_name.required' => 'Tên dịch vụ là bắt buộc.',
            'service_name.string' => 'Tên dịch vụ phải là một chuỗi.',
            'service_name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
        } else {
            $imagePath = null;
        }

        // Loại bỏ dấu phẩy phân cách hàng nghìn
        $cleanPrice = str_replace(',', '', $request->price);

        DB::beginTransaction();
        
        try {
            $service = Service::create([
                'service_name' => $request->service_name,
                'description' => $request->description,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'created_by' => optional(Auth::user()->employee)->id,
                'is_hot' => $request->has('is_hot') ? 1 : 0,
                'image' => $imagePath,
            ]);

            // Lưu giá theo thời hạn
            if ($request->has('duration_prices')) {
                foreach ($request->duration_prices as $durationId => $price) {
                    if (!empty($price)) {
                        // Loại bỏ dấu phẩy phân cách hàng nghìn trước khi lưu
                        $cleanDurationPrice = str_replace(',', '', $price);
                        
                        ContractDuration::create([
                            'service_id' => $service->id,
                            'duration_id' => $durationId,
                            'price' => $cleanDurationPrice,
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được thêm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }
        
    // Hiển thị chi tiết một dịch vụ
    public function show($id)
    {
        $service = Service::with(['category', 'employee', 'contractDurations.duration'])->findOrFail($id);  
        return view('admin.services.show', compact('service'));
    }
    
    // Hiển thị form chỉnh sửa dịch vụ
    public function edit($id)
    {
        $service = Service::with(['category', 'contractDurations'])->findOrFail($id);
        $categories = ServiceCategory::all();
        $durations = Duration::orderBy('months')->get();
        return view('admin.services.edit', compact('service', 'categories', 'durations'));
    }

    // Cập nhật thông tin dịch vụ
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'service_name' => 'required|string|max:255|unique:services,service_name,' . $id,
            'description' => 'required|string',
            'content' => 'required|string',
            
            'category_id' => 'required|exists:service_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'duration_prices' => 'nullable|array',
            'duration_prices.*' => 'nullable|string',
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $imagePath = $request->file('image')->store('services', 'public');
        } else {
            $imagePath = $service->image;
        }

        // Loại bỏ dấu phẩy phân cách hàng nghìn
        $cleanPrice = str_replace(',', '', $request->price);

        DB::beginTransaction();
        
        try {
            $service->update([
                'service_name' => $request->service_name,
                'description' => $request->description,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'is_hot' => $request->has('is_hot') ? 1 : 0,
                'image' => $imagePath,
            ]);

            // Cập nhật giá theo thời hạn
            if ($request->has('duration_prices')) {
                foreach ($request->duration_prices as $durationId => $price) {
                    if (empty($price)) {
                        // Xóa giá nếu trống
                        ContractDuration::where('service_id', $service->id)
                            ->where('duration_id', $durationId)
                            ->delete();
                        continue;
                    }
                    
                    $cleanDurationPrice = str_replace(',', '', $price);
                    
                    ContractDuration::updateOrCreate(
                        [
                            'service_id' => $service->id,
                            'duration_id' => $durationId
                        ],
                        ['price' => $cleanDurationPrice]
                    );
                }
            }
            
            DB::commit();
            return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }
   
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            // Xóa các contract durations liên quan trước
            ContractDuration::where('service_id', $id)->delete();
            
            // Sau đó xóa dịch vụ
            $service = Service::findOrFail($id);
            
            // Xóa ảnh nếu có
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            $service->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Xóa dịch vụ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa dịch vụ: ' . $e->getMessage());
        }
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name',
        ]);

        ServiceCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Tạo danh mục dịch vụ thành công!');
    }

    public function deleteCategory($id)
    {
        try {
            $category = ServiceCategory::findOrFail($id);
            
            // Kiểm tra xem có dịch vụ nào dùng danh mục này không
            if ($category->services()->exists()) {
                return redirect()->back()->with('error', 'Không thể xóa danh mục đang được sử dụng bởi các dịch vụ');
            }
            
            $category->delete();
            return redirect()->back()->with('success', 'Xóa danh mục thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage());
        }
    }
}