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
        if (!Schema::hasColumn('self_risk_assessment_questionnaire', 'counter')) {
            Schema::table('self_risk_assessment_questionnaire', function (Blueprint $table) {
                $table->bigInteger('counter')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_risk_assessment_questionnaire', 'counter')) {
            Schema::table('self_risk_assessment_questionnaire', function (Blueprint $table) {
                $table->dropColumn('counter');
            });
        }
    }
};
