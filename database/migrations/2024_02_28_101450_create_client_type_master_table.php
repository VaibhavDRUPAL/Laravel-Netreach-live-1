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
        if (!Schema::hasTable('client_type_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('client_type_master', function (Blueprint $table) {
                $table->bigIncrements('client_type_id');
                $table->string('client_type');
                $table->string('client_type_slug')->unique();
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
        Schema::dropIfExists('client_type_master');
    }
};
