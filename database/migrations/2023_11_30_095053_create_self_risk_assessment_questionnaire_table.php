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
        if (!Schema::hasTable('self_risk_assessment_questionnaire')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('self_risk_assessment_questionnaire', function (Blueprint $table) {
                $table->bigIncrements('question_id');
                $table->string('question');
                $table->string('question_slug');
                $table->string('answer_input_type');
                $table->integer('priority');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('self_risk_assessment_questionnaire');
    }
};
