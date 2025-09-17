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
        if (!Schema::hasTable('blogs')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('blogs', function (Blueprint $table) {
                $table->bigIncrements('blog_id');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('title');
                $table->longText('description');
                $table->string('image');
                $table->text('youtube_video_embed');
                $table->string('tags');
                $table->string('meta_title');
                $table->string('meta_description');
                $table->string('meta_keywords');
                $table->boolean('status')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('blogs');
    }
};
