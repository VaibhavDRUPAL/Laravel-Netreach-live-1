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
        if (!Schema::hasTable('chatbot_questionnaire')) {
            Schema::create('chatbot_questionnaire', function (Blueprint $table) {
                $table->bigIncrements('question_id');
                $table->integer('priority');
                $table->longText('question');
                $table->longText('answer_sheet')->nullable();
                $table->bigInteger('counter')->default(0);
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
        Schema::dropIfExists('chatbot_questionnaire');
    }
};