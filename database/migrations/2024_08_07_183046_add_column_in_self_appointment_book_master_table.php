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
        if (!Schema::hasColumns('self_appointment_book_master', ['treated_state_id', 'treated_district_id', 'treated_center_id'])) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->foreignId('treated_state_id')->after('media_path')->nullable()->index()->constrained('state_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('treated_district_id')->after('treated_state_id')->nullable()->index()->constrained('district_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('treated_center_id')->after('treated_district_id')->nullable()->index()->constrained('centre_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('self_appointment_book_master', ['treated_state_id', 'treated_district_id', 'treated_center_id'])) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->dropConstrainedForeignId('treated_state_id');
                $table->dropConstrainedForeignId('treated_district_id');
                $table->dropConstrainedForeignId('treated_center_id');
            });
        }
    }
};
