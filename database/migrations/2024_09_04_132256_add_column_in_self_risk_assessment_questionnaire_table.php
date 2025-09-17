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
        if (!Schema::hasColumn('self_risk_assessment_questionnaire', 'group_no')) {
            Schema::table('self_risk_assessment_questionnaire', function (Blueprint $table) {
                $table->integer('group_no')->default(0)->after('priority');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_risk_assessment_questionnaire', 'group_no')) {
            Schema::table('self_risk_assessment_questionnaire', function (Blueprint $table) {
                $table->dropColumn('group_no');
            });
        }
    }
};
