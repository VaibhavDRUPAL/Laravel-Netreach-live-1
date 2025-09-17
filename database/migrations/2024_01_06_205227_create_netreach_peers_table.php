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
        Schema::create('netreach_peers', function (Blueprint $table) {
            $table->id();
            $table->string('netreach_peer_Code')->nullable();
            $table->string('date_of_outreach')->nullable();
            $table->string('location_of_client')->nullable();
            $table->string('name_of_appplatform_client')->nullable();
            $table->string('name_of_client')->nullable();
            $table->string('clients_Age')->nullable();
            $table->string('gender')->nullable();
            $table->string('type_of_target_population')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('netreach_peers');
    }
};
