<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Role;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
//chỗ này dùng để xác định trong web.php(route) khi gọi controller thì nó sẽ gọi đến file này
//ví dụ: Route::get('/home', [HomeController::class, 'index'])->name('home');
//HomeController::class sẽ gọi đến file HomeController.php trong thư mục app/Http/Controllers
//và file HomeController.php sẽ kế thừa từ file Controller.php này
//và khi gọi hàm index thì nó sẽ gọi đến hàm index trong file HomeController.php
//và hàm index trong file HomeController.php sẽ trả về view home.blade.php
//và view home.blade.php sẽ hiển thị