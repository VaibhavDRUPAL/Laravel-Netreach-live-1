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
        if (!Schema::hasTable('self_risk_assessment_answers')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('self_risk_assessment_answers', function (Blueprint $table) {
                $table->bigIncrements('answer_id');
                $table->foreignId('question_id')->index()->constrained('self_risk_assessment_questionnaire')->references('question_id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('answer');
                $table->string('answer_slug');
                $table->integer('weight')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('self_risk_assessment_answers');
    }
};
