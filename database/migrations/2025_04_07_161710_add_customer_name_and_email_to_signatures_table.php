<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('signatures', function (Blueprint $table) {
            $table->string('customer_name')->after('contract_id'); // Thêm cột tên khách hàng
            $table->string('customer_email')->after('customer_name'); // Thêm cột email khách hàng
        });
    }

    public function down(): void
    {
        Schema::table('signatures', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_email']); // Xóa cột nếu rollback
        });
    }
};