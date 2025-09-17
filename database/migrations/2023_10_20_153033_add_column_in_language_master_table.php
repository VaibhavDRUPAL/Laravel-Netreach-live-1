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
        if (!Schema::hasColumn('language_master', 'label_as')) {
            Schema::table('language_master', function (Blueprint $table) {
                $table->string('label_as')->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('language_master', 'label_as')) {
            Schema::table('language_master', function (Blueprint $table) {
                $table->dropColumn('label_as');
            });
        }
    }
};
