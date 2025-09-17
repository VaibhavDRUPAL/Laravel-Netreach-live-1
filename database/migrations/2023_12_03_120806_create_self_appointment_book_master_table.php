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
        if (!Schema::hasTable('self_appointment_book_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('self_appointment_book_master', function (Blueprint $table) {
                $table->bigIncrements('appointment_id');
                $table->foreignId('state_id')->index()->constrained('state_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('district_id')->index()->constrained('district_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('center_id')->index()->constrained('centre_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('referral_no');
                $table->string('uid');
                $table->string('full_name');
                $table->string('mobile_no');
                $table->longText('services');
                $table->date('appointment_date');
                $table->string('media_path')->nullable();
                $table->dateTime('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('self_appointment_book_master');
    }
};
