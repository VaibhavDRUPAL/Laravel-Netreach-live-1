<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('vn_email')->nullable()->unique();
                $table->string('phone_number')->nullable();
                $table->string('profile_photo')->nullable();
                $table->string('txt_password')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->dateTime('email_verified_at')->nullable();
                $table->boolean('status')->default(false);
                $table->smallInteger('user_type');
                $table->integer('vms_details_ids');
                $table->string('manual_link')->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
};