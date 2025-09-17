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
        if (!Schema::hasTable('vm_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('vm_master', function (Blueprint $table) {
                $table->id();
                $table->integer('parent_id')->default(0);
                $table->string('vncode')->nullable()->collation('utf8_general_ci');
                $table->string('name')->collation('utf8_general_ci');
                $table->string('last_name')->nullable()->collation('utf8_general_ci');
                $table->string('email')->nullable()->collation('utf8_general_ci');
                $table->string('mobile_number')->collation('utf8_general_ci');
                $table->string('region')->nullable()->collation('utf8_general_ci');
                $table->string('state_code_old')->collation('utf8_general_ci');
                $table->string('state_code')->collation('utf8_general_ci');
                $table->boolean('status')->default(1);
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
        Schema::dropIfExists('vm_master');
    }
};
