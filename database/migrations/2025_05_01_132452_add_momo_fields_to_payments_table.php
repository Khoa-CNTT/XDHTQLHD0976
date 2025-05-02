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
    Schema::table('payments', function (Blueprint $table) {
        $table->string('partner_code')->nullable()->after('request_id');
        $table->text('signature')->nullable()->after('partner_code');
        $table->text('ipn_response')->nullable()->after('signature');
        $table->text('error_message')->nullable()->after('ipn_response');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['partner_code', 'signature', 'ipn_response', 'error_message']);
        });
    }
};
