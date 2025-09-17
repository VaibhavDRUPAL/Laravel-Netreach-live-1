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
        if (!Schema::hasTable('vm_master_count_start')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('vm_master_count_start', function (Blueprint $table) {
                $table->id();
                $table->foreignId('state_id')->constrained('state_master')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('vm_counting_start');
                $table->integer('vm_type');
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
        Schema::dropIfExists('vm_master_count_start');
    }
};
