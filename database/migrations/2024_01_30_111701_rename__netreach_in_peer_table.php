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
        if (Schema::hasColumn('netreach_peers', 'author_ID')) {
            Schema::table('netreach_peers', function (Blueprint $table) {
                $table->renameColumn('author_ID', 'user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('netreach_peers', 'user_id')) {
            Schema::table('netreach_peers', function (Blueprint $table) {
                $table->renameColumn('user_id', 'author_ID');
            });
        }
    }
};