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
        if (!Schema::hasColumn('state_master', 'weight')) {
            Schema::table('state_master', function (Blueprint $table) {
                $table->integer('weight')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('state_master', 'weight')) {
            Schema::table('state_master', function (Blueprint $table) {
                $table->dropColumn('weight');
            });
        }
    }
};
