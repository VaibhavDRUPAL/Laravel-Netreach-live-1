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
        if (!Schema::hasTable('language_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('language_master', function (Blueprint $table) {
                $table->bigIncrements('language_id');
                $table->string('name');
                $table->string('language_code');
                $table->string('locale')->unique();
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
        Schema::dropIfExists('language_master');
    }
};
