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
        if (Schema::hasColumn('state_master', 'region')) {
            Schema::table('state_master', function (Blueprint $table) {
                $table->string('region')->default(null)->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('state_master', 'region')) {
            Schema::table('state_master', function (Blueprint $table) {
                $table->string('region')->default('1,2,3,4')->nullable(false)->change();
            });
        }
    }
};
