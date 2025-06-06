<?php
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\ServiceController as CustomerServiceController;
use App\Http\Controllers\Customer\ContractController as CustomerContractController;
use App\Http\Controllers\Customer\VnPayController as VNPayPaymentController;
use App\Http\Controllers\Customer\ContractAmendmentController as CustomerContractAmendmentController;
use App\Http\Controllers\Customer\SignatureController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\CustomerProfileController ;
use App\Http\Controllers\Customer\NotificationController;
use App\Http\Controllers\Customer\SupportTicketController as CustomerSupportTicketController;

use App\Http\Controllers\Admin\ContractAmendmentController as AdminContractAmendmentController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\DurationController;
use App\Http\Controllers\Admin\ContractDurationController;
use App\Http\Controllers\Admin\AdminSignatureController;
use App\Http\Controllers\Admin\AdminCustomerSignatureController as AdminCustomerSignatureController;
use App\Http\Controllers\Admin\SettingController;

use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\ContractController as EmployeeContractController;
use App\Http\Controllers\Employee\ServiceController as EmployeeServiceController;
use App\Http\Controllers\Employee\PaymentController as EmployeePaymentController;
use App\Http\Controllers\Employee\SupportTicketController as EmployeeSupportTicketController;
use App\Http\Controllers\Employee\ProfileController as EmployeeProfileController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ConfirmPasswordController;    








Route::view('/offline', 'offline')->name('offline'); 


Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
Route::get('/services/{id}', [CustomerServiceController::class, 'show'])->name('customer.services.show');
Route::get('/services', [CustomerServiceController::class, 'index'])->name('customer.services.index');
Route::get('/services/filter/{type}', [CustomerServiceController::class, 'filter'])->name('customer.services.filter');
Route::get('/customer/services/search', [CustomerServiceController::class, 'search'])->name('customer.services.search');
Route::get('/services/category/{id}', [CustomerServiceController::class, 'filterByCategory'])->name('customer.services.filterByCategory');

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'employee') {
            return redirect()->route('admin.dashboard'); 
        } elseif (Auth::user()->role === 'customer') {
            return redirect()->route('customer.dashboard'); 
        }
    }

  
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

        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        
        
        Route::get('/admin/signature', [AdminSignatureController::class, 'showForm'])->name('signature.form');
        Route::post('/admin/signature', [AdminSignatureController::class, 'save'])->name('signature.save');
        
       
        Route::prefix('customer-signatures')->name('customer-signatures.')->group(function() {
            Route::get('/', [AdminCustomerSignatureController::class, 'index'])->name('index');
            Route::get('/{customerId}', [AdminCustomerSignatureController::class, 'show'])->name('show');
            Route::post('/{customerId}/upload', [AdminCustomerSignatureController::class, 'upload'])->name('upload');
            Route::delete('/{signatureId}', [AdminCustomerSignatureController::class, 'delete'])->name('delete');
        });
        
        
        

        
        Route::prefix('durations')->name('durations.')->group(function() {
            Route::get('/', [DurationController::class, 'index'])->name('index');
            Route::get('/create', [DurationController::class, 'create'])->name('create');
            Route::post('/', [DurationController::class, 'store'])->name('store');
            Route::get('/{duration}/edit', [DurationController::class, 'edit'])->name('edit');
            Route::put('/{duration}', [DurationController::class, 'update'])->name('update');
            Route::delete('/{duration}', [DurationController::class, 'destroy'])->name('destroy');
            Route::get('/price-config', [DurationController::class, 'priceConfig'])->name('price-config');
            Route::post('/save-price', [DurationController::class, 'savePrice'])->name('save-price');
            Route::post('/calculate-prices', [DurationController::class, 'calculatePrices'])->name('calculate-prices');
            Route::post('/{duration}/set-default-prices', [DurationController::class, 'setDefaultPrices'])->name('set-default-prices');
        });
        
    
        Route::prefix('services')->name('services.')->group(function() {
            Route::get('/{service}/durations', [ContractDurationController::class, 'showServicePriceForm'])->name('contract-durations.edit');
            Route::post('/{service}/durations', [ContractDurationController::class, 'saveServicePrices'])->name('contract-durations.save');
            Route::get('/{service}/durations/{duration}/price', [ContractDurationController::class, 'getServicePrice'])->name('contract-durations.price');
            Route::delete('/{service}/durations/{duration}', [ContractDurationController::class, 'deleteServicePrice'])->name('contract-durations.delete');
            Route::post('/batch-update-prices', [ContractDurationController::class, 'batchUpdatePrices'])->name('contract-durations.batch-update');
            Route::post('/apply-price-formula', [ContractDurationController::class, 'applyPriceFormula'])->name('contract-durations.apply-formula');
        });

        Route::resource('customers', CustomerController::class);
        Route::resource('employees', EmployeeController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/admin/reports/export', [ReportController::class, 'exportToExcel'])->name('reports.export');

        Route::post('customers/{id}/ban', [CustomerController::class, 'ban'])->name('customers.ban');
        Route::post('customers/{id}/unban', [CustomerController::class, 'unban'])->name('customers.unban');
      
        Route::put('/contracts/{id}/update-status', [AdminContractController::class, 'updateStatus'])->name('contracts.updateStatus');
        Route::post('/admin/contracts/{id}/confirm-cancel', [AdminContractController::class, 'confirmCancel'])->name('contracts.confirmCancel');
        
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
        Route::put('/payments/{id}', [AdminPaymentController::class, 'update'])->name('payments.update');
        Route::get('/payments-report', [AdminPaymentController::class, 'createReport'])->name('payments.report');
        Route::post('/payments-export', [AdminPaymentController::class, 'exportPdf'])->name('payments.export');

        Route::resource('service-categories', ServiceCategoryController::class)->except(['show']);
        Route::post('services/categories', [AdminServiceController::class, 'createCategory'])->name('services.categories.create');
        Route::delete('services/categories/{id}', [AdminServiceController::class, 'deleteCategory'])->name('services.categories.delete');

     
        
        

        Route::get('/contracts/{contractId}/amendments', [AdminContractAmendmentController::class, 'index'])->name('contracts.admendments.index');
        Route::get('/contracts/admendments', [AdminContractAmendmentController::class, 'create'])->name('contracts.admendments.create');
        Route::post('', [AdminContractAmendmentController::class, 'store'])->name('contracts.admendments.store');
        
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/create', [AdminNotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');
        Route::get('/notifications/mass-create', [AdminNotificationController::class, 'createMassNotification'])->name('notifications.mass-create');
        Route::post('/notifications/mass-send', [AdminNotificationController::class, 'storeMassNotification'])->name('notifications.mass-send');
        Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications', [AdminNotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
     
        Route::get('/support', [AdminSupportTicketController::class, 'index'])->name('support.index');
        Route::get('/support/{id}', [AdminSupportTicketController::class, 'show'])->name('support.show');
        Route::put('/support/{id}', [AdminSupportTicketController::class, 'update'])->name('support.update');
        Route::post('/support/{id}/respond', [AdminSupportTicketController::class, 'respond'])->name('support.respond');
        Route::post('support-tickets/{id}/assign', [AdminSupportTicketController::class, 'assignStaff'])->name('support.assign');
        Route::get('/support/{id}/check-typing', [AdminSupportTicketController::class, 'checkTypingStatus'])->name('support.check-typing');
        Route::get('/support/{id}/check-responses', [AdminSupportTicketController::class, 'checkNewResponses'])->name('support.check-responses');
        


        
        // Routes cho nhân viên 
        Route::get('/profile', [EmployeeProfileController::class, 'show'])->name('profile.show');
        Route::post('/profile', [EmployeeProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/change-password', [EmployeeProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('/profile/update-avatar', [EmployeeProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
        
       
        Route::group([], function() {
            Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
            Route::get('/employee/contracts', [EmployeeContractController::class, 'index'])->name('employee.contracts.index');
            Route::get('/employee/contracts/{id}', [EmployeeContractController::class, 'show'])->name('employee.contracts.show');
            Route::put('/employee/contracts/{id}/update-status', [EmployeeContractController::class, 'updateStatus'])->name('employee.contracts.updateStatus');
            Route::put('/employee/contracts/{id}/complete', [EmployeeContractController::class, 'markAsComplete'])->name('employee.contracts.complete');
            Route::post('/employee/contracts/{id}/confirm-cancel', [EmployeeContractController::class, 'confirmCancel'])->name('employee.contracts.confirmCancel');
            
            Route::get('/employee/services', [EmployeeServiceController::class, 'index'])->name('employee.services.index');
            Route::get('/employee/services/{id}', [EmployeeServiceController::class, 'show'])->name('employee.services.show');
            
            Route::get('/employee/payments', [EmployeePaymentController::class, 'index'])->name('employee.payments.index');
            Route::get('/employee/payments/{id}', [EmployeePaymentController::class, 'show'])->name('employee.payments.show');
            Route::put('/employee/payments/{id}', [EmployeePaymentController::class, 'update'])->name('employee.payments.update');
            
            Route::get('/employee/support', [EmployeeSupportTicketController::class, 'index'])->name('employee.support.index');
            Route::get('/employee/support/{id}', [EmployeeSupportTicketController::class, 'show'])->name('employee.support.show');
            Route::post('/employee/support/{id}/respond', [EmployeeSupportTicketController::class, 'respond'])->name('employee.support.respond');
        });

    
   
        Route::get('/contracts/{id}/sign', [AdminContractController::class, 'showSigningForm'])->name('contracts.sign');
        Route::post('/contracts/{id}/sign', [AdminContractController::class, 'saveSignature'])->name('contracts.sign.save');
        Route::get('/contracts/{id}/pdf', [AdminContractController::class, 'generateContractPdf'])->name('contracts.pdf');
    });
// Customer routes
Route::middleware([\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\CustomerMiddleware::class])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('contracts', [CustomerContractController::class, 'index'])->name('contracts.index');
        Route::get('contracts/{id}', [CustomerContractController::class, 'show'])->name('contracts.show');
      
        Route::post('/support/create', [CustomerSupportTicketController::class, 'createSupportTicket'])->name('support.create');
        Route::get('/support', [CustomerSupportTicketController::class, 'listSupportTickets'])->name('support.index');
        Route::get('/support/{id}', [CustomerSupportTicketController::class, 'viewSupportTicket'])->name('support.show');
        Route::post('/support/{id}/respond', [CustomerSupportTicketController::class, 'respondToSupportTicket'])->name('support.respond');
        Route::post('/support/{id}/typing', [CustomerSupportTicketController::class, 'updateTypingStatus'])->name('support.typing');
        Route::get('/support/{id}/check-responses', [CustomerSupportTicketController::class, 'checkNewResponses'])->name('support.check-responses');
        Route::post('/support/{id}/close', [CustomerSupportTicketController::class, 'closeSupportTicket'])->name('support.close');

        Route::get('/profile', [CustomerProfileController::class, 'profile'])->name('profile');
        Route::post('/profile', [CustomerProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('/profile/change-password', [CustomerProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::post('/profile/update-avatar', [CustomerProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
  
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        
        Route::get('/api/notifications/check', [NotificationController::class, 'checkNewNotifications']);
        Route::get('/api/notifications/latest', [NotificationController::class, 'getLatestNotifications']);
     
        Route::post('/contracts/{id}/vnpay-payment', [VNPayPaymentController::class, 'createPayment'])->name('vnpay.payment');
        Route::get('/vnpay/return', [VNPayPaymentController::class, 'return'])->name('vnpay.success');
        Route::match(['get', 'post'], '/vnpay/ipn', [VNPayPaymentController::class, 'ipn'])->name('vnpay.ipn');
        
        Route::get('/', [CustomerContractAmendmentController::class, 'index'])->name('index');

        Route::get('contracts/sign/{id}', [SignatureController::class, 'showSignForm'])->name('contracts.sign');
        Route::post('contracts/{id}/send-otp', [SignatureController::class, 'sendOtp'])->name('contracts.sendOtp');
        Route::post('contracts/{id}/sign', [SignatureController::class, 'sign'])->name('contracts.sign.submit');
        Route::post('/customer/contracts/{id}/request-cancel', [CustomerContractController::class, 'requestCancel'])->name('contracts.requestCancel');
          
        Route::get('payments', [CustomerPaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{id}', [CustomerPaymentController::class, 'show'])->name('payments.show');
        Route::get('payments/{id}/download', [CustomerPaymentController::class, 'downloadReceipt'])->name('payments.download');

        Route::get('/customer/contracts/{id}/download', [CustomerContractController::class, 'downloadPdf']) ->name('contracts.download');
        Route::get('/contracts/{id}/pdf', [CustomerContractController::class, 'downloadPdf'])->name('contracts.pdf');
    }); 

