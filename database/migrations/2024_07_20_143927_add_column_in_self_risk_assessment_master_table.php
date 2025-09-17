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
        if (!Schema::hasColumn('self_risk_assessment_master', 'unique_id')) {
            Schema::table('self_risk_assessment_master', function (Blueprint $table) {
                $table->string('unique_id')->after('state_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_risk_assessment_master', 'unique_id')) {
            Schema::table('self_risk_assessment_master', function (Blueprint $table) {
                $table->dropColumn('unique_id');
            });
        }
    }
};