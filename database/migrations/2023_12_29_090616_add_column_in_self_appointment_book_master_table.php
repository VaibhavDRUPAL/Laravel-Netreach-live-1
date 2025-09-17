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
        if (!Schema::hasColumn('self_appointment_book_master', 'vn_id')) {
            Schema::disableForeignKeyConstraints();
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->foreignId('vn_id')->after('appointment_id')->nullable()->index()->constrained('vm_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('self_appointment_book_master', 'vn_id')) {
            Schema::disableForeignKeyConstraints();
            Schema::table('self_appointment_book_master', function (Blueprint $table) {
                $table->dropConstrainedForeignId('vn_id');
            });
        }
    }
};
