<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('support_tickets', function (Blueprint $table) {
        $table->unsignedBigInteger('assigned_employee_id')->nullable()->after('user_id');
        // Nếu cần, thêm foreign key:
        // $table->foreign('assigned_employee_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('support_tickets', function (Blueprint $table) {
        $table->dropColumn('assigned_employee_id');
    });
}
};
