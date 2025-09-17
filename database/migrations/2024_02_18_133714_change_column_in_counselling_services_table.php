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
        if (Schema::hasColumn('counselling_services', 'follow_up_date')) {
            Schema::table('counselling_services', function (Blueprint $table) {
                $table->string('follow_up_date')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('counselling_services', 'follow_up_date')) {
            Schema::table('counselling_services', function (Blueprint $table) {
                $table->string('follow_up_date')->nullable(false)->change();
            });
        }
    }
};
