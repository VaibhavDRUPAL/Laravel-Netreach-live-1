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
        if (!Schema::hasTable('target_population_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('target_population_master', function (Blueprint $table) {
                $table->bigIncrements('target_id');
                $table->string('target_type');
                $table->string('target_slug');
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
        Schema::dropIfExists('target_population_master');
    }
};
