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
        if (!Schema::hasColumn('self_appointment_book_master', 'remark')) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->string('remark')->after('evidence_path')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_appointment_book_master', 'remark')) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->dropColumn('remark');
            });
        }
    }
};
