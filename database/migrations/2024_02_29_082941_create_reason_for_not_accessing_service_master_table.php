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
        if (!Schema::hasTable('reason_for_not_accessing_service_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('reason_for_not_accessing_service_master', function (Blueprint $table) {
                $table->bigIncrements('reason_id');
                $table->string('reason');
                $table->string('reason_slug')->unique();
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
        Schema::dropIfExists('reason_for_not_accessing_service_master');
    }
};
