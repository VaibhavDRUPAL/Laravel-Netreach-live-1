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
        if (!Schema::hasColumns('blogs', ['author_name', 'author_details', 'facebook', 'whatsapp', 'instagram'])) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('author_name')->nullable(false)->default(null);
                $table->string('author_details')->nullable(false)->default(null);
                $table->string('facebook')->nullable(false)->default(null);
                $table->string('whatsapp')->nullable(false)->default(null);
                $table->string('instagram')->nullable(false)->default(null);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('author_name');
            $table->dropColumn('author_details');
            $table->dropColumn('facebook');
            $table->dropColumn('whatsapp');
            $table->dropColumn('instagram');
        }); 
    }
};
