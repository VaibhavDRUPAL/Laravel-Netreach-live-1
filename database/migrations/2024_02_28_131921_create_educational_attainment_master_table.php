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
        if (!Schema::hasTable('educational_attainment_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('educational_attainment_master', function (Blueprint $table) {
                $table->bigIncrements('educational_attainment_id');
                $table->string('educational_attainment');
                $table->string('educational_attainment_slug')->unique();
                $table->dateTime('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('educational_attainment_master');
    }
};
