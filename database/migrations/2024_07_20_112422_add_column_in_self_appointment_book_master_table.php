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
        if (!Schema::hasColumns('self_appointment_book_master', ['pre_art_no', 'on_art_no', 'updated_by', 'updated_at'])) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->string('pre_art_no')->after('evidence_path')->nullable();
                $table->string('on_art_no')->after('pre_art_no')->nullable();
                $table->bigInteger('updated_by')->nullable();
                $table->dateTime('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('self_appointment_book_master', ['pre_art_no', 'on_art_no', 'updated_by', 'updated_at'])) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->dropColumn('pre_art_no');
                $table->dropColumn('on_art_no');
                $table->dropColumn('updated_by');
                $table->dropColumn('updated_at');
            });
        }
    }
};