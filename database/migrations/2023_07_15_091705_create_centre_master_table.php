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
        if (!Schema::hasTable('centre_master')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('centre_master', function (Blueprint $table) {
                $table->id();
                $table->foreignId('district_id')->constrained('district_master')->onUpdate('cascade')->onDelete('cascade');
                $table->string('name')->nullable();
                $table->string('address')->nullable();
                $table->string('pin_code')->nullable();
                $table->string('state_code');
                $table->string('services_avail')->nullable()->comment('ICTC-1,FICTC-2,ART-3,TI-4,Private lab-5');
                $table->string('services_available')->nullable()->comment('HIV Test - 1 STI Services - 2 PrEP - 3 PEP - 4 Counselling for Mental Health - 5 Referral to TI services - 6 ART Linkages - 7 Others - 8');
                $table->string('name_counsellor')->nullable();
                $table->string('centre_contact_no')->nullable();
                $table->string('incharge')->nullable()->comment('Name of the ICTC Incharge / Medical Officer');
                $table->string('contact_no')->nullable();
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('centre_master');
    }
};
