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
        if (!Schema::hasColumn('blogs', 'blog_category_id'))
        {
            Schema::table('blogs', function (Blueprint $table) { 
                $table->biginteger('blog_category_id')->unsigned();
                $table->foreign('blog_category_id')->references('blog_category_id')->on('blog_categories')->onUpdate('cascade')->onDelete('cascade'); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('blogs', 'blog_category_id'))
        {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropForeign(['blog_category_id']);
                $table->dropColumn('blog_category_id');
            });
        }
    }
};
