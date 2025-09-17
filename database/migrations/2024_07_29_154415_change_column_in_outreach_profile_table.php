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
        if (Schema::hasColumn('outreach_profile', 'unique_serial_number')) {
            Schema::table('outreach_profile', function (Blueprint $table) {
                $table->dropUnique('outreach_profile_unique_serial_number_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('outreach_profile', 'unique_serial_number')) {
            Schema::table('outreach_profile', function (Blueprint $table) {
                $table->string('unique_serial_number')->unique()->change();
            });
        }
    }
};