<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Duration;
use App\Models\Service;
use App\Models\ContractDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DurationController extends Controller
{
    /**
     * Hiển thị danh sách các thời hạn
     */
    public function index()
    {
        $durations = Duration::orderBy('months', 'asc')->get();
        return view('admin.durations.index', compact('durations'));
    }

    /**
     * Hiển thị form thêm thời hạn mới
     */
    public function create()
    {
        return view('admin.durations.create');
    }

    /**
     * Lưu thời hạn mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255|unique:durations',
            'months' => 'required|integer|min:1|unique:durations',
        ], [
            'label.required' => 'Tên thời hạn không được để trống',
            'label.unique' => 'Tên thời hạn đã tồn tại',
            'months.required' => 'Số tháng không được để trống',
            'months.integer' => 'Số tháng phải là số nguyên',
            'months.min' => 'Số tháng phải lớn hơn 0',
            'months.unique' => 'Số tháng đã tồn tại',
        ]);

        Duration::create([
            'label' => $request->label,
            'months' => $request->months,
        ]);

        return redirect()->route('admin.durations.index')
            ->with('success', 'Thêm thời hạn mới thành công');
    }

    /**
     * Hiển thị form chỉnh sửa thời hạn
     */
    public function edit(Duration $duration)
    {
        return view('admin.durations.edit', compact('duration'));
    }

    /**
     * Cập nhật thời hạn vào database
     */
    public function update(Request $request, Duration $duration)
    {
        $request->validate([
            'label' => 'required|string|max:255|unique:durations,label,' . $duration->id,
            'months' => 'required|integer|min:1|unique:durations,months,' . $duration->id,
        ], [
            'label.required' => 'Tên thời hạn không được để trống',
            'label.unique' => 'Tên thời hạn đã tồn tại',
            'months.required' => 'Số tháng không được để trống',
            'months.integer' => 'Số tháng phải là số nguyên',
            'months.min' => 'Số tháng phải lớn hơn 0',
            'months.unique' => 'Số tháng đã tồn tại',
        ]);

        $duration->update([
            'label' => $request->label,
            'months' => $request->months,
        ]);

        return redirect()->route('admin.durations.index')
            ->with('success', 'Cập nhật thời hạn thành công');
    }

    /**
     * Xóa thời hạn khỏi database
     */
    public function destroy(Duration $duration)
    {
        // Kiểm tra xem có contract_durations nào đang sử dụng duration này không
        $hasContractDurations = ContractDuration::where('duration_id', $duration->id)->exists();
        
        if ($hasContractDurations) {
            return redirect()->route('admin.durations.index')
                ->with('error', 'Không thể xóa thời hạn này vì đang được sử dụng trong các dịch vụ');
        }

        $duration->delete();
        
        return redirect()->route('admin.durations.index')
            ->with('success', 'Xóa thời hạn thành công');
    }

    /**
     * Hiển thị form thiết lập giá cho dịch vụ theo thời hạn
     */
    public function priceConfig()
    {
        $services = Service::orderBy('service_name')->get();
        $durations = Duration::orderBy('months')->get();
        $contractDurations = ContractDuration::all()->groupBy('service_id');
        
        return view('admin.durations.price-config', compact('services', 'durations', 'contractDurations'));
    }

    /**
     * Lưu giá dịch vụ theo thời hạn
     */
    public function savePrice(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'prices' => 'required|array',
            'prices.*.*' => 'nullable|string',
        ], [
            'prices.required' => 'Dữ liệu giá không được để trống',
        ]);

        DB::beginTransaction();
        
        try {
            foreach ($request->prices as $serviceId => $durationPrices) {
                foreach ($durationPrices as $durationId => $price) {
                    // Nếu price rỗng hoặc 0, bỏ qua hoặc xóa nếu đã tồn tại
                    if (empty($price)) {
                        ContractDuration::where('service_id', $serviceId)
                            ->where('duration_id', $durationId)
                            ->delete();
                        continue;
                    }
                    
                    // Chuyển đổi giá từ định dạng "123,456" thành "123456"
                    $cleanPrice = str_replace(',', '', $price);
                    
                    // Cập nhật hoặc tạo mới
                    ContractDuration::updateOrCreate(
                        ['service_id' => $serviceId, 'duration_id' => $durationId],
                        ['price' => $cleanPrice]
                    );
                }
            }
            
            DB::commit();
            return redirect()->route('admin.durations.price-config')
                ->with('success', 'Cập nhật giá dịch vụ theo thời hạn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tính giá tự động dựa trên công thức
     */
    public function calculatePrices(Request $request)
    {
        $request->validate([
            'base_duration_id' => 'required|exists:durations,id',
            'target_duration_id' => 'required|exists:durations,id',
            'multiplier' => 'required|numeric|min:0.1',
            'apply_to_all' => 'nullable|boolean'
        ]);

        DB::beginTransaction();
        
        try {
            $baseDurationId = $request->base_duration_id;
            $targetDurationId = $request->target_duration_id;
            $multiplier = $request->multiplier;
            
            $query = ContractDuration::where('duration_id', $baseDurationId);
            
            // Nếu không áp dụng cho tất cả, chỉ áp dụng cho các dịch vụ được chọn
            if (!$request->apply_to_all && $request->has('services')) {
                $query->whereIn('service_id', $request->services);
            }
            
            $basePrices = $query->get();
            
            foreach ($basePrices as $basePrice) {
                $newPrice = round($basePrice->price * $multiplier);
                
                ContractDuration::updateOrCreate(
                    [
                        'service_id' => $basePrice->service_id,
                        'duration_id' => $targetDurationId
                    ],
                    ['price' => $newPrice]
                );
            }
            
            DB::commit();
            return redirect()->route('admin.durations.price-config')
                ->with('success', 'Đã áp dụng công thức tính giá thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Đặt giá mặc định cho thời hạn mới
     */
    public function setDefaultPrices(Duration $duration, Request $request)
    {
        $request->validate([
            'default_price_ratio' => 'required|numeric|min:0.1',
            'base_duration_id' => 'required|exists:durations,id',
        ]);
        
        $baseDurationId = $request->base_duration_id;
        $ratio = $request->default_price_ratio;
        
        DB::beginTransaction();
        
        try {
            // Lấy tất cả dịch vụ có giá cho thời hạn cơ sở
            $baseContractDurations = ContractDuration::where('duration_id', $baseDurationId)->get();
            
            foreach ($baseContractDurations as $baseContractDuration) {
                $newPrice = round($baseContractDuration->price * $ratio);
                
                ContractDuration::updateOrCreate(
                    [
                        'service_id' => $baseContractDuration->service_id,
                        'duration_id' => $duration->id
                    ],
                    ['price' => $newPrice]
                );
            }
            
            DB::commit();
            return redirect()->route('admin.durations.index')
                ->with('success', 'Đã thiết lập giá mặc định cho thời hạn ' . $duration->label);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }
} 