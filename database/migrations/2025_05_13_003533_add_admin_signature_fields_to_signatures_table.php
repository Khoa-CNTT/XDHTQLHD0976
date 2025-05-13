<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('signatures', function (Blueprint $table) {
            $table->text('admin_signature_data')->nullable()->after('signature_image')->comment('Dữ liệu chữ ký admin dạng Base64');
            $table->text('admin_signature_image')->nullable()->after('admin_signature_data')->comment('Ảnh chữ ký admin dạng Base64');
            $table->timestamp('admin_signed_at')->nullable()->after('admin_signature_image')->comment('Thời gian admin ký hợp đồng');
            $table->string('admin_name')->nullable()->after('admin_signed_at')->comment('Tên người đại diện bên A');
            $table->string('admin_position')->nullable()->after('admin_name')->comment('Chức vụ người đại diện bên A');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signatures', function (Blueprint $table) {
            $table->dropColumn([
                'admin_signature_data',
                'admin_signature_image',
                'admin_signed_at',
                'admin_name',
                'admin_position'
            ]);
        });
    }
};
