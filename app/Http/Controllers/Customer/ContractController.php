<?php

namespace App\Http\Controllers\Customer;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\Service;

use App\Models\Signature;

class ContractController extends Controller
{
    public function index()
    {
        try {
            $customer = Auth::user()->customer;

            $contracts = Contract::with(['service' => function($query) {
                 
                    $query->withDefault([
                        'service_name' => 'Dịch vụ không tồn tại'
                    ]);
                }])
                ->where('customer_id', $customer->id)
                ->get();

            return view('customer.contracts.index', compact('contracts'));
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi tải danh sách hợp đồng: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $contract = Contract::with(['customer.user', 'service' => function($query) {
              
                $query->withDefault([
                    'service_name' => 'Dịch vụ không tồn tại'
                ]);
            }, 'signatures', 'payments'])
            ->findOrFail($id);

            return view('customer.contracts.show', compact('contract'));
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi tải thông tin hợp đồng: ' . $e->getMessage());
        }
    }

    public function requestCancel($id)
    {
        $contract = Contract::findOrFail($id);
        $customer = Auth::user()->customer;
        if ($contract->customer_id !== $customer->id) {
            return redirect()->back()->with('error', 'Bạn không có quyền huỷ hợp đồng này.');
        }
        if ($contract->status === 'Đã huỷ') {
            return redirect()->back()->with('error', 'Hợp đồng đã bị huỷ trước đó.');
        }
        if ($contract->status === 'Yêu cầu huỷ') {
            return redirect()->back()->with('error', 'Bạn đã gửi yêu cầu huỷ hợp đồng này.');
        }
        $contract->status = 'Yêu cầu huỷ';
        $contract->save();
        return redirect()->back()->with('success', 'Yêu cầu huỷ hợp đồng đã được gửi. Quản trị viên sẽ xác nhận!');
    }
}






    
