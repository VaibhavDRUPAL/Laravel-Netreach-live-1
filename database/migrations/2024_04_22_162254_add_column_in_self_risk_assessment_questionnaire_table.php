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
        if (!Schema::hasColumns('self_risk_assessment_questionnaire', ['is_active', 'is_deleted'])) {
            Schema::table('self_risk_assessment_questionnaire', function (Blueprint $table) {
                $table->boolean('is_active')->default(true);
                $table->boolean('is_deleted')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('self_risk_assessment_questionnaire', ['is_active', 'is_deleted'])) {
            Schema::table('self_risk_assessment_questionnaire', function (Blueprint $table) {
                $table->dropColumn('is_active');
                $table->dropColumn('is_deleted');
            });
        }
    }
};
