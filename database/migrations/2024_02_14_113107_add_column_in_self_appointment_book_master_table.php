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
        if (!Schema::hasColumn('self_appointment_book_master', 'assessment_id')) {
            Schema::disableForeignKeyConstraints();
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->foreignId('assessment_id')->after('appointment_id')->index()->constrained('self_risk_assessment_master')->references('risk_assessment_id')->onUpdate('cascade')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_appointment_book_master', 'assessment_id')) {
            Schema::disableForeignKeyConstraints();
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->dropConstrainedForeignId('assessment_id');
            });
        }
    }
};
