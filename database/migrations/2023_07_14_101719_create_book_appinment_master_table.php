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
        if (!Schema::hasTable('book_appinment_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('book_appinment_master', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('customers')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('state_id')->constrained('state_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('survey_id')->constrained('surveys')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('district_id');
                $table->string('survey_unique_ids');
                $table->string('e_referral_no');
                $table->integer('center_ids');
                $table->string('serach_by');
                $table->string('pincode', 25);
                $table->date('appoint_date');
                $table->dateTime('created_at');
                $table->dateTime('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('book_appinment_master');
    }
};