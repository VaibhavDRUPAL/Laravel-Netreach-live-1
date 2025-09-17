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
        if (!Schema::hasColumn('self_appointment_book_master', 'type_of_test')) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->integer('type_of_test')->after('on_art_no')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_appointment_book_master', 'type_of_test')) {
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->dropColumn('type_of_test');
            });
        }
    }
};