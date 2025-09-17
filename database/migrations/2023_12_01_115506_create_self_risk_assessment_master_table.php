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
        if (!Schema::hasTable('self_risk_assessment_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('self_risk_assessment_master', function (Blueprint $table) {
                $table->bigIncrements('risk_assessment_id');
                $table->foreignId('state_id')->index()->constrained('state_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('mobile_no');
                $table->integer('risk_score');
                $table->longText('raw_answer_sheet');
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
        Schema::dropIfExists('self_risk_assessment_master');
    }
};
