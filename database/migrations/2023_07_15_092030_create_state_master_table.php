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
        if (!Schema::hasTable('state_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('state_master', function (Blueprint $table) {
                $table->id();
                $table->integer('state_code')->unique();
                $table->string('state_name');
                $table->string('st_cd')->nullable()->unique();
                $table->string('region')->default('1,2,3,4')->comment('North:1,South:2,East:3,West:4');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('state_master');
    }
};
