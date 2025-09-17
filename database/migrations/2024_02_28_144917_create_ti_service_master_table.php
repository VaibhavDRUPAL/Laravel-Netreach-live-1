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
        if (!Schema::hasTable('ti_service_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('ti_service_master', function (Blueprint $table) {
                $table->bigIncrements('ti_service_id');
                $table->string('ti_service');
                $table->string('ti_service_slug')->unique();
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
        Schema::dropIfExists('ti_service_master');
    }
};
