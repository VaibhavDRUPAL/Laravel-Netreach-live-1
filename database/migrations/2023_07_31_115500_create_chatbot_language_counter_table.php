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
        if (!Schema::hasTable('chatbot_language_counter')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('chatbot_language_counter', function (Blueprint $table) {
                $table->bigIncrements('language_counter_id');
                $table->foreignId('language_id')->constrained('language_master')->references('language_id')->onUpdate('cascade')->onDelete('cascade');
                $table->bigInteger('counter')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('chatbot_language_counter');
    }
};