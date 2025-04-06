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
// Route mặc định: Chuyển hướng dựa trên vai trò của người dùng
Route::get('/', function () {
    if (Auth::check()) {
        // Kiểm tra vai trò của người dùng
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard'); // Chuyển hướng đến trang admin
        } elseif (Auth::user()->role === 'customer') {
            return redirect('/customer/dashboard'); // Chuyển hướng đến trang khách hàng
        }
    }

    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    return redirect('/login');
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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
        Route::get('contracts', [CustomerContractController::class, 'index'])->name('customer.contracts.index');
        Route::get('contracts/{id}', [CustomerContractController::class, 'show'])->name('customer.contracts.show');
        Route::post('contracts/{id}/sign', [CustomerContractController::class, 'sign'])->name('customer.contracts.sign');
        Route::post('contracts/{id}/send-otp', [CustomerContractController::class, 'sendOtp'])->name('customer.contracts.sendOtp');
    });

// Router trang ca nhan
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/profile', [App\Http\Controllers\CustomerProfileController::class, 'profile'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\CustomerProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [App\Http\Controllers\CustomerProfileController::class, 'changePassword'])->name('profile.change-password');
});