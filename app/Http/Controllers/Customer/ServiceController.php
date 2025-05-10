<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceReview;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    public function __construct()
{
    // Chỉ áp dụng middleware cho các phương thức cần thiết
    $this->middleware('auth')->except(['show', 'filter', 'search', 'index']);
}
public function filter($type)
{
    if ($type === 'Tất Cả Dịch Vụ') {
        $services = Service::orderByDesc('is_hot')
            ->orderByDesc('created_at')
            ->paginate(9);
    } else {
        // Lọc dịch vụ theo category_name
        $category = ServiceCategory::where('name', $type)->first();
        if ($category) {
            $services = Service::where('category_id', $category->id)
                ->orderByDesc('is_hot')
                ->orderByDesc('created_at')
                ->paginate(9);
        } else {
            $services = collect(); // Không có loại dịch vụ tương ứng
        }
    }

    return view('customer.services.index', [
        'services' => $services,
        'type' => $type,
    ]);
}

public function show($id)
{
    try {
        
        $service = Service::with('reviews.customer')->findOrFail($id);
        return view('customer.services.show', compact('service'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return redirect()->route('customer.services.index')
            ->with('error', 'Dịch vụ không tồn tại hoặc đã bị xóa.');
    } catch (\Exception $e) {
        return redirect()->route('customer.services.index')
            ->with('error', 'Đã xảy ra lỗi khi truy cập dịch vụ.');
    }
}
public function filterByCategory($categoryId)
{
    $category = ServiceCategory::findOrFail($categoryId);
    $services = Service::where('category_id', $categoryId)
        ->orderByDesc('is_hot')
        ->orderByDesc('created_at')
        ->paginate(9);

    return view('customer.services.index', compact('services', 'category'));
}
public function addReview(Request $request, $serviceId)
{
    $request->validate([
        'rating' => 'required|integer|between:1,5',
        'comment' => 'nullable|string',
    ]);

    ServiceReview::create([
        'service_id' => $serviceId,
        'customer_id' => Auth::user()->customer->id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return redirect()->route('customer.services.show', $serviceId)->with('success', 'Đánh giá của bạn đã được thêm.');
}
public function index()
{
    $services = Service::with('category')  
        ->orderByDesc('is_hot')
        ->orderByDesc('created_at')
        ->paginate(9);

    return view('customer.services.index', compact('services'));
}

public function search(Request $request)
{
    $query = $request->input('query');
    
    // Initialize services collection
    $services = Service::query();
    
    // Only perform search if query has at least 2 characters
    if ($query && strlen(trim($query)) >= 2) {
        $services = $services->where(function($q) use ($query) {
            // Search in service name with higher priority (using exact match or starts with)
            $q->where('service_name', 'LIKE', "%{$query}%");
            
            // Search in description (lower priority)
            $q->orWhere('description', 'LIKE', "%{$query}%");
            
            // Try to match price if query is numeric
            if (is_numeric($query)) {
                $q->orWhere('price', '=', $query);
            }
            
            // Search in category names
            $q->orWhereHas('category', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            });
        });
    } elseif ($query && strlen(trim($query)) < 2) {
        // If query is too short, add flash message
        return redirect()->route('customer.services.index')
            ->with('search_error', 'Vui lòng nhập ít nhất 2 ký tự để tìm kiếm.');
    }
    
    // Apply standard sorting
    $services = $services->orderByDesc('is_hot')
        ->orderByDesc('created_at')
        ->paginate(9);

    $type = $query && strlen(trim($query)) >= 2 ? "Kết quả tìm kiếm cho: '{$query}'" : 'Tất Cả Dịch Vụ';

    return view('customer.services.index', compact('services', 'query', 'type'));
}

}