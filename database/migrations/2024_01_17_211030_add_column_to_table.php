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
        Schema::table('netreach_peers', function (Blueprint $table){
            $table->string('serial_number_of_client')->after('netreach_peer_Code')->nullable();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('netreach_peers', function (Blueprint $table){
            //
        });
    }
};
