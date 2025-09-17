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
        if (!Schema::hasTable('service_type_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('service_type_master', function (Blueprint $table) {
                $table->bigIncrements('service_type_id');
                $table->string('service_type');
                $table->string('service_type_slug')->unique();
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
        Schema::dropIfExists('service_type_master');
    }
};
