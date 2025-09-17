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
        if (Schema::hasColumn('self_appointment_book_master', 'assessment_id')) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->foreignId('assessment_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_appointment_book_master', 'assessment_id')) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->foreignId('assessment_id')->nullable(false)->change();
            });
        }
    }
};
