<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Customer\ContractController as CustomerContractController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminOrEmployeeMiddleware;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Controllers\Customer\CustomerProfileController;


Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

Route::get('/', function () {
    if (Auth::check()) {
        // Kiểm tra vai trò của người dùng
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Chuyển hướng đến dashboard admin
        } elseif (Auth::user()->role === 'customer') {
            return redirect()->route('customer.dashboard'); // Chuyển hướng đến dashboard khách hàng
        }
    }

    // Nếu chưa đăng nhập, chuyển hướng đến trang khách hàng
    return redirect()->route('customer.dashboard');
});
// Routes cho khách chưa đăng nhập
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
});

// Route đăng xuất
Route::post('/logout', function () {
    Auth::logout(); // Đăng xuất người dùng
    return redirect()->route('customer.dashboard'); // Chuyển hướng về trang customer/dashboard
})->name('logout');

// Admin và Employee routes
Route::middleware([\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\AdminOrEmployeeMiddleware::class])
    ->prefix('admin')
     ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('contracts', AdminContractController::class);
        Route::resource('services', AdminServiceController::class);
    });
// Customer routes
Route::middleware([\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\CustomerMiddleware::class])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('contracts', [CustomerContractController::class, 'index'])->name('contracts.index');
        Route::get('contracts/{id}', [CustomerContractController::class, 'show'])->name('contracts.show');
        Route::post('contracts/{id}/sign', [CustomerContractController::class, 'sign'])->name('customer.contracts.sign');
        Route::post('contracts/{id}/send-otp', [CustomerContractController::class, 'sendOtp'])->name('customer.contracts.sendOtp');

        Route::get('services', [CustomerContractController::class, 'index'])->name('services.index');

        Route::get('/profile', [App\Http\Controllers\CustomerProfileController::class, 'profile'])->name('profile');
        Route::post('/profile', [App\Http\Controllers\CustomerProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/change-password', [App\Http\Controllers\CustomerProfileController::class, 'changePassword'])->name('profile.change-password');
        
    });

