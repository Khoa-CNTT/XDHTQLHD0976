<?php
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ServiceController as CustomerServiceController;
use App\Http\Controllers\Customer\ContractController as CustomerContractController;
use App\Http\Controllers\Customer\MoMoPaymentController as MoMoPaymentController;
use App\Http\Controllers\Customer\VNPayController as VNPayPaymentController;
use App\Http\Controllers\Customer\ContractAmendmentController as CustomerContractAmendmentController;
use App\Http\Controllers\Customer\SignatureController;




use App\Http\Controllers\Admin\ContractAmendmentController as AdminContractAmendmentController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ConfirmPasswordController;    
use App\Http\Controllers\Admin\ReportController;





Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

Route::get('/services/{id}', [CustomerServiceController::class, 'show'])->name('customer.services.show');

Route::get('services', [CustomerServiceController::class, 'index'])->name('customer.services.index');


      // Routes cho dịch vụ (cho phép cả khách và người dùng đã đăng nhập)
      Route::get('/services/filter/{type}', [\App\Http\Controllers\Customer\ServiceController::class, 'filter'])->name('customer.services.filter');
      Route::get('/customer/services/search', [\App\Http\Controllers\Customer\ServiceController::class, 'search'])->name('customer.services.search');



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


       // Routes cho quên mật khẩu
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // Xác thực email
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Xác nhận mật khẩu
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);
    
    


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

        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
        Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');


        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->except(['create', 'edit', 'store', 'update']);
        Route::post('customers/{id}/ban', [\App\Http\Controllers\Admin\CustomerController::class, 'ban'])->name('customers.ban');
        Route::post('customers/{id}/unban', [\App\Http\Controllers\Admin\CustomerController::class, 'unban'])->name('customers.unban');


      
        Route::put('/contracts/{id}/update-status', [AdminContractController::class, 'updateStatus'])->name('contracts.updateStatus');
        Route::put('/contracts/{id}/complete', [AdminContractController::class, 'markAsComplete'])->name('contracts.complete');
        Route::post('/admin/contracts/{id}/confirm-cancel', [AdminContractController::class, 'confirmCancel'])->name('contracts.confirmCancel');

        
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
        Route::put('/payments/{id}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('payments.update');
        Route::get('/payments-report', [\App\Http\Controllers\Admin\PaymentController::class, 'createReport'])->name('payments.report');
        Route::post('/payments-export', [\App\Http\Controllers\Admin\PaymentController::class, 'exportPdf'])->name('payments.export');

        Route::resource('service-categories', ServiceCategoryController::class)->except(['show']);
        Route::post('services/categories', [AdminServiceController::class, 'createCategory'])->name('services.categories.create');
        Route::delete('services/categories/{id}', [AdminServiceController::class, 'deleteCategory'])->name('services.categories.delete');


        Route::get('/contracts/{contractId}/amendments', [AdminContractAmendmentController::class, 'index'])->name('contracts.admendments.index');
        Route::get('/contracts/admendments', [AdminContractAmendmentController::class, 'create'])->name('contracts.admendments.create');
        Route::post('', [AdminContractAmendmentController::class, 'store'])->name('contracts.admendments.store');
        
       
        Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/create', [\App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
        Route::get('/notifications/mass-create', [\App\Http\Controllers\Admin\NotificationController::class, 'createMassNotification'])->name('notifications.mass-create');
        Route::post('/notifications/mass-send', [\App\Http\Controllers\Admin\NotificationController::class, 'storeMassNotification'])->name('notifications.mass-send');
        Route::delete('/notifications/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');

     
        Route::get('/support', [\App\Http\Controllers\Admin\SupportTicketController::class, 'index'])->name('support.index');
        Route::get('/support/{id}', [\App\Http\Controllers\Admin\SupportTicketController::class, 'show'])->name('support.show');
        Route::put('/support/{id}', [\App\Http\Controllers\Admin\SupportTicketController::class, 'update'])->name('support.update');
        Route::post('/support/{id}/respond', [\App\Http\Controllers\Admin\SupportTicketController::class, 'respond'])->name('support.respond');
    });
// Customer routes
Route::middleware([\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\CustomerMiddleware::class])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('contracts', [CustomerContractController::class, 'index'])->name('contracts.index');
        Route::get('contracts/{id}', [CustomerContractController::class, 'show'])->name('contracts.show');

      
        Route::post('/support/create', [App\Http\Controllers\CustomerProfileController::class, 'createSupportTicket'])->name('support.create');
        Route::get('/support', [App\Http\Controllers\CustomerProfileController::class, 'listSupportTickets'])->name('support.index');
        Route::get('/support/{id}', [App\Http\Controllers\CustomerProfileController::class, 'viewSupportTicket'])->name('support.show');
        Route::post('/support/{id}/respond', [App\Http\Controllers\CustomerProfileController::class, 'respondToSupportTicket'])->name('support.respond');

        Route::get('services/category/{id}', [CustomerServiceController::class, 'filterByCategory'])->name('services.filterByCategory');
        



        Route::get('/profile', [App\Http\Controllers\CustomerProfileController::class, 'profile'])->name('profile');
        Route::post('/profile', [App\Http\Controllers\CustomerProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/change-password', [App\Http\Controllers\CustomerProfileController::class, 'changePassword'])->name('profile.change-password');
         
        // Notification routes for customer
        Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        
       
        Route::get('/api/notifications/check', [\App\Http\Controllers\NotificationController::class, 'checkNewNotifications']);
        Route::get('/api/notifications/latest', [\App\Http\Controllers\NotificationController::class, 'getLatestNotifications']);
     

        Route::post('/contracts/{id}/vnpay-payment', [VNPayPaymentController::class, 'createPayment'])->name('vnpay.payment');
        Route::get('/vnpay/return', [VNPayPaymentController::class, 'return'])->name('vnpay.success');
        Route::post('/vnpay/ipn', [\App\Http\Controllers\Customer\VNPayController::class, 'ipn'])->name('vnpay.ipn');
        
              
        Route::get('/', [CustomerContractAmendmentController::class, 'index'])->name('index');



        Route::get('contracts/sign/{id}', [SignatureController::class, 'showSignForm'])->name('contracts.sign');
        Route::post('contracts/{id}/send-otp', [SignatureController::class, 'sendOtp'])->name('contracts.sendOtp');
        Route::post('contracts/{id}/sign', [SignatureController::class, 'sign'])->name('contracts.sign.submit');
        Route::post('/customer/contracts/{id}/request-cancel', [CustomerContractController::class, 'requestCancel'])->name('contracts.requestCancel');
          
        Route::get('payments', [App\Http\Controllers\Customer\PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{id}', [App\Http\Controllers\Customer\PaymentController::class, 'show'])->name('payments.show');
        Route::get('payments/{id}/download', [App\Http\Controllers\Customer\PaymentController::class, 'downloadReceipt'])->name('payments.download');
        
    }); 

