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
        if (!Schema::hasTable('district_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('district_master', function (Blueprint $table) {
                $table->id();
                $table->integer('state_code');
                $table->integer('district_code');
                $table->string('district_name')->nullable();
                $table->string('dst_cd')->nullable();
                $table->string('st_cd')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('district_master');
    }
};
