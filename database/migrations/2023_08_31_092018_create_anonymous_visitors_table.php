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
        if (!Schema::hasTable('anonymous_visitors')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('anonymous_visitors', function (Blueprint $table) {
                $table->bigIncrements('visitor_id');
                $table->string('ip_address');
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->string('country')->nullable();
                $table->string('state')->nullable();
                $table->string('city')->nullable();
                $table->string('zip')->nullable();
                $table->string('isp')->nullable();
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
        Schema::dropIfExists('anonymous_visitors');
    }
};
