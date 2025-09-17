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
        if (Schema::hasColumn('district_master', 'district_name')) {
            Schema::table('district_master', function (Blueprint $table) {
                $table->string('district_name')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('district_master', 'district_name')) {
            Schema::table('district_master', function (Blueprint $table) {
                $table->string('district_name')->nullable()->change();
            });
        }
    }
};
