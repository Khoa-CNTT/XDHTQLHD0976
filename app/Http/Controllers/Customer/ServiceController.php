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
        $this->middleware('auth')->except([
            'show', 
            'filter', 
            'search', 
            'index', 
            'filterByCategory'
        ]);
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
            $service = Service::with(['reviews.customer', 'contractDurations.duration'])->findOrFail($id);
            
            // Lấy các thời hạn có giá đã được thiết lập cho dịch vụ này
            $availableDurations = $service->contractDurations()
                ->select('contract_durations.*', 'durations.months', 'durations.label')
                ->join('durations', 'contract_durations.duration_id', '=', 'durations.id')
                ->orderBy('durations.months', 'asc')
                ->get();
            
            return view('customer.services.show', compact('service', 'availableDurations'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('customer.services.index')->with('error', 'Dịch vụ không tồn tại!');
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
     
        $services = Service::query();
        
       
        if ($query && strlen(trim($query)) >= 2) {
            $services = $services->where(function($q) use ($query) {
            
                $q->where('service_name', 'LIKE', "%{$query}%");
                
              
                $q->orWhere('description', 'LIKE', "%{$query}%");
                
      
                $q->orWhereHas('category', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                });
            });
        } elseif ($query && strlen(trim($query)) < 2) {
        
            return redirect()->route('customer.services.index')
                ->with('search_error', 'Vui lòng nhập ít nhất 2 ký tự để tìm kiếm.');
        }
        
     
        $services = $services->orderByDesc('is_hot')
            ->orderByDesc('created_at')
            ->paginate(9);

        $type = $query && strlen(trim($query)) >= 2 ? "Kết quả tìm kiếm cho: '{$query}'" : 'Tất Cả Dịch Vụ';

        return view('customer.services.index', compact('services', 'query', 'type'));
    }
}