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
        if (!Schema::hasTable('media_type')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('media_type', function (Blueprint $table) {
                $table->bigIncrements('media_type_id');
                $table->string('type_name');
                $table->string('slug')->unique();
                $table->longText('scope');
                $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('media_type');
    }
};
