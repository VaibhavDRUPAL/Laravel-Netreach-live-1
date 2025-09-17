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
        if (!Schema::hasTable('chatbot_greetings')) {
            Schema::create('chatbot_greetings', function (Blueprint $table) {
                $table->bigIncrements('greeting_id');
                $table->string('greeting_title');
                $table->longText('greetings')->nullable();
                $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('chatbot_greetings');
    }
};