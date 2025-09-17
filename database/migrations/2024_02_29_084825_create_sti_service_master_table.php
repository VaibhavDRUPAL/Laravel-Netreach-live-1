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
        if (!Schema::hasTable('sti_service_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('sti_service_master', function (Blueprint $table) {
                $table->bigIncrements('sti_service_id');
                $table->string('sti_service');
                $table->string('sti_service_slug')->unique();
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
        Schema::dropIfExists('sti_service_master');
    }
};
