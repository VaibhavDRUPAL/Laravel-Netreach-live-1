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
        if (!Schema::hasTable('primary_occupation_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('primary_occupation_master', function (Blueprint $table) {
                $table->bigIncrements('occupation_id');
                $table->string('occupation');
                $table->string('occupation_slug')->unique();
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
        Schema::dropIfExists('primary_occupation_master');
    }
};
