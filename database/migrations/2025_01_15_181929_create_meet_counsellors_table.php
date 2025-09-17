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
        if (!Schema::hasTable('meet_counsellor_follow_ups')) {
        Schema::create('meet_counsellor_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meet_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('contacted')->default(false);
            $table->text('action_taken');
            $table->text('follow_up_image')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meet_counsellors');
    }
};
