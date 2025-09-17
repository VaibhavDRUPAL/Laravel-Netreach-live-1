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
        if (!Schema::hasTable('customers')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->smallInteger('anony');
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone_number')->nullable()->unique();
                $table->string('profile_photo')->nullable();
                $table->string('email_verified_at')->nullable();
                $table->string('password');
                $table->string('remember_token')->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->boolean('status')->default(false);
                $table->smallInteger('hiv_test');
                $table->string('uid')->nullable();
                $table->smallInteger('client_type')->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('customers');
    }
};
