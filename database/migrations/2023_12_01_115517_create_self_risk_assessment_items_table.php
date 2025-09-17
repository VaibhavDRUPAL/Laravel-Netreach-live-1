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
        if (!Schema::hasTable('self_risk_assessment_items')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('self_risk_assessment_items', function (Blueprint $table) {
                $table->bigIncrements('risk_assessment_item_id');
                $table->foreignId('risk_assessment_id')->index()->constrained('self_risk_assessment_master')->references('risk_assessment_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('question_id')->index()->constrained('self_risk_assessment_questionnaire')->references('question_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('answer_id')->index()->constrained('self_risk_assessment_answers')->references('answer_id')->onUpdate('cascade')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('self_risk_assessment_items');
    }
};
