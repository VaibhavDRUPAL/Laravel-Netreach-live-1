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
        if(!Schema::hasTable('client_response_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('client_response_master', function (Blueprint $table) {
                $table->bigIncrements('response_id');
                $table->string('response');
                $table->string('response_slug')->unique();
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
        Schema::dropIfExists('client_response_master');
    }
};
