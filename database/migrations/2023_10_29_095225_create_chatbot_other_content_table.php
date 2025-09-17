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
        if (!Schema::hasTable('chatbot_other_content')) {
            Schema::create('chatbot_other_content', function (Blueprint $table) {
                $table->bigIncrements('content_id');
                $table->string('title');
                $table->string('description');
                $table->string('slug');
                $table->longText('content');
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
        Schema::dropIfExists('chatbot_other_content');
    }
};
