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
        if(!Schema::hasColumn('outreach_profile', 'is_deleted')) {
            Schema::table('outreach_profile', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }
        if(!Schema::hasColumn('outreach_counselling_services', 'is_deleted')) {
            Schema::table('outreach_counselling_services', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }
        if(!Schema::hasColumn('outreach_plhiv', 'is_deleted')) {
            Schema::table('outreach_plhiv', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }
        if(!Schema::hasColumn('outreach_referral_service', 'is_deleted')) {
            Schema::table('outreach_referral_service', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }
        if(!Schema::hasColumn('outreach_risk_assesment', 'is_deleted')) {
            Schema::table('outreach_risk_assesment', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }
        if(!Schema::hasColumn('outreach_sti_services', 'is_deleted')) {
            Schema::table('outreach_sti_services', function (Blueprint $table) {
                $table->boolean('is_deleted')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('outreach_profile', 'is_deleted')) {
            Schema::table('outreach_profile', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
        if (Schema::hasColumn('outreach_counselling_services', 'is_deleted')) {
            Schema::table('outreach_counselling_services', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
        if (Schema::hasColumn('outreach_plhiv', 'is_deleted')) {
            Schema::table('outreach_plhiv', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
        if (Schema::hasColumn('outreach_referral_service', 'is_deleted')) {
            Schema::table('outreach_referral_service', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
        if (Schema::hasColumn('outreach_risk_assesment', 'is_deleted')) {
            Schema::table('outreach_risk_assesment', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
        if (Schema::hasColumn('outreach_sti_services', 'is_deleted')) {
            Schema::table('outreach_sti_services', function (Blueprint $table) {
                $table->dropColumn('is_deleted');
            });
        }
    }
};
