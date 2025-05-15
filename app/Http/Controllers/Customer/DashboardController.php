<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
use App\Models\Service;
class DashboardController extends Controller
{
   

    public function index()
    {
        $isLoggedIn = Auth::check();
        $user = $isLoggedIn ? Auth::user() : null;
        
        // Get services without the price column
        $services = Service::select('id', 'image', 'service_name', 'description', 'created_by', 'created_at', 'is_hot','category_id') 
            ->with('category')  
            ->orderByDesc('is_hot')        
            ->orderByDesc('created_at')      
            ->paginate(9);                  
        
        return view('customer.dashboard', compact('isLoggedIn', 'user', 'services'));
    }
    public function show($id)
    {
        $contract = Contract::with('service')->findOrFail($id);
        return view('customer.contracts.show', compact('contract'));
    }
}
