<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function filter($type)
    {
        if ($type === 'Tất Cả') {
            $contracts = Contract::with('service')->paginate(10); // Phân trang
        } else {
            $contracts = Contract::with('service')
                ->whereHas('service', function ($query) use ($type) {
                    $query->where('service_type', $type);
                })
                ->paginate(10); // Phân trang
        }
    
        return view('customer.contracts.index', compact('contracts', 'type'));
    }
}