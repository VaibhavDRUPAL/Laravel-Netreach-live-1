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
        if (!Schema::hasTable('genrates')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('genrates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('platform_id')->constrained('platforms')->onUpdate('cascade')->onDelete('cascade');
                $table->text('user_identified');
                $table->text('unique_code_link')->nullable();
                $table->longText('tinyurl')->nullable();
                $table->text('detail')->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('genrates');
    }
};
