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
        if (!Schema::hasColumn('district_master', 'state_id')) {
            Schema::disableForeignKeyConstraints();
            Schema::table('district_master', function (Blueprint $table) {
                $table->foreignId('state_id')->after('id')->index()->constrained('state_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('district_master', 'state_id')) {
            Schema::disableForeignKeyConstraints();
            Schema::table('district_master', function (Blueprint $table) {
                $table->dropConstrainedForeignId('state_id');
            });
        }
    }
};
