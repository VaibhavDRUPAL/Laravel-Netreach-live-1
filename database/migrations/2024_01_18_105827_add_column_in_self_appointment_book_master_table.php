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
        if (!Schema::hasColumns('self_appointment_book_master', ['not_access_the_service_referred', 'date_of_accessing_service', 'pid_provided_at_the_service_center', 'outcome_of_the_service_sought', 'evidence_path'])) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->string('not_access_the_service_referred')->after('appointment_date')->nullable();
                $table->date('date_of_accessing_service')->after('not_access_the_service_referred')->nullable();
                $table->string('pid_provided_at_the_service_center')->after('date_of_accessing_service')->nullable();
                $table->string('outcome_of_the_service_sought')->after('pid_provided_at_the_service_center')->nullable();
                $table->text('evidence_path')->after('media_path')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('self_appointment_book_master', ['not_access_the_service_referred', 'date_of_accessing_service', 'pid_provided_at_the_service_center', 'outcome_of_the_service_sought', 'evidence_path'])) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->dropColumn('not_access_the_service_referred');
                $table->dropColumn('date_of_accessing_service');
                $table->dropColumn('pid_provided_at_the_service_center');
                $table->dropColumn('outcome_of_the_service_sought');
                $table->dropColumn('evidence_path');
            });
        }
    }
};
