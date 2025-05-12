<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Duration;
use App\Models\ContractDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractDurationController extends Controller
{
    /**
     * Hiển thị form thiết lập giá cho một dịch vụ cụ thể
     */
    public function showServicePriceForm($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $durations = Duration::orderBy('months')->get();
        $contractDurations = ContractDuration::where('service_id', $serviceId)
            ->get()
            ->keyBy('duration_id');
        
        return view('admin.durations.service-prices', compact('service', 'durations', 'contractDurations'));
    }
    
    /**
     * Lưu giá cho một dịch vụ cụ thể
     */
    public function saveServicePrices(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);
        
        $request->validate([
            'durations' => 'required|array',
            'durations.*' => 'nullable|numeric|min:0',
        ], [
            'durations.required' => 'Dữ liệu giá không được để trống',
            'durations.*.numeric' => 'Giá phải là số',
            'durations.*.min' => 'Giá không được nhỏ hơn 0',
        ]);
        
        DB::beginTransaction();
        
        try {
            foreach ($request->durations as $durationId => $price) {
                // Nếu price rỗng hoặc 0, xóa nếu đã tồn tại
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
            
            DB::commit();
            return redirect()->route('admin.services.show', $serviceId)
                ->with('success', 'Cập nhật giá dịch vụ theo thời hạn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Cập nhật hàng loạt giá dịch vụ theo thời hạn
     */
    public function batchUpdatePrices(Request $request)
    {
        $request->validate([
            'prices' => 'required|array',
            'prices.*.*' => 'nullable|string', // Cho phép chuỗi vì sẽ có định dạng số
        ], [
            'prices.required' => 'Dữ liệu giá không được để trống',
        ]);
        
        DB::beginTransaction();
        
        try {
            foreach ($request->prices as $serviceId => $durationPrices) {
                foreach ($durationPrices as $durationId => $price) {
                    // Nếu price rỗng, xóa nếu đã tồn tại
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
            return redirect()->back()->with('success', 'Cập nhật giá dịch vụ hàng loạt thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * API trả về giá cho một dịch vụ theo thời hạn
     */
    public function getServicePrice($serviceId, $durationId)
    {
        $contractDuration = ContractDuration::where('service_id', $serviceId)
            ->where('duration_id', $durationId)
            ->first();
            
        if (!$contractDuration) {
            return response()->json(['error' => 'Không tìm thấy giá cho thời hạn này'], 404);
        }
        
        return response()->json([
            'price' => $contractDuration->price,
            'formatted_price' => number_format($contractDuration->price, 0, '.', ',') . ' VNĐ'
        ]);
    }
    
    /**
     * Xóa một giá theo thời hạn
     */
    public function deleteServicePrice($serviceId, $durationId)
    {
        $contractDuration = ContractDuration::where('service_id', $serviceId)
            ->where('duration_id', $durationId)
            ->first();
            
        if ($contractDuration) {
            $contractDuration->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'Không tìm thấy giá cho thời hạn này'], 404);
    }

    /**
     * Cập nhật hàng loạt giá sử dụng một công thức áp dụng cho một thời hạn
     */
    public function applyPriceFormula(Request $request)
    {
        $request->validate([
            'source_duration' => 'required|exists:durations,id',
            'target_duration' => 'required|exists:durations,id',
            'multiplier' => 'required|numeric|min:0.1',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);
        
        DB::beginTransaction();
        
        try {
            $sourceDurationId = $request->source_duration;
            $targetDurationId = $request->target_duration;
            $multiplier = $request->multiplier;
            
            foreach ($request->services as $serviceId) {
                // Lấy giá của thời hạn nguồn
                $sourceDuration = ContractDuration::where('service_id', $serviceId)
                    ->where('duration_id', $sourceDurationId)
                    ->first();
                
                if ($sourceDuration) {
                    // Tính giá mới
                    $newPrice = round($sourceDuration->price * $multiplier);
                    
                    // Cập nhật hoặc tạo mới
                    ContractDuration::updateOrCreate(
                        ['service_id' => $serviceId, 'duration_id' => $targetDurationId],
                        ['price' => $newPrice]
                    );
                }
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Áp dụng công thức tính giá thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
        }
    }
} 