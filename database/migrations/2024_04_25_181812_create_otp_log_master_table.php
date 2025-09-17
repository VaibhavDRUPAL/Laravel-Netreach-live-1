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
        if(!Schema::hasTable('otp_log_master')) {
            Schema::create('otp_log_master', function (Blueprint $table) {
                $table->bigIncrements('log_id');
                $table->string('mobile_no');
                $table->bigInteger('counter')->default(1);
                $table->dateTime('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_log_master');
    }
};
