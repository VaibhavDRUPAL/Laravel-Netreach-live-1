<?php

use App\Models\Outreach\Counselling;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('counselling_services')) {
            $data = DB::table('counselling_services')->get();
            mediaOperations(BACKUP_PATH . 'counselling_services' . EXT_JSON, $data->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            Schema::disableForeignKeyConstraints();
            Schema::drop('counselling_services');
        }

        if (!Schema::hasTable('outreach_counselling_services')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('outreach_counselling_services', function (Blueprint $table) {
                $table->bigIncrements('counselling_services_id');
                $table->foreignId('profile_id')->nullable()->index()->constrained('outreach_profile')->references('profile_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('client_type_id')->nullable()->index()->constrained('client_type_master')->references('client_type_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->index()->constrained('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('referral_service_id')->nullable()->index()->constrained('outreach_referral_service')->references('referral_service_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('district_id')->nullable()->constrained('district_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('state_id')->nullable()->constrained('state_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('target_id')->nullable()->index()->constrained('target_population_master')->references('target_id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('referred_from')->nullable()->comment('Approached by the Client-1 VN-2 NETREACH Counsellor-3 Self-Identified -4 Others -99');
                $table->string('referral_source')->nullable()->comment('If Others (Specify) Referral Source');
                $table->string('name_the_client')->nullable();
                $table->date('date_of_counselling')->nullable();
                $table->string('phone_number')->nullable();
                $table->string('location')->nullable();
                $table->string('other_target_population')->nullable()->comment('If Others, Please Specify');
                $table->string('type_of_counselling_offered')->nullable()->comment('HIV Counselling -1 STI Counselling-2 Positive living Counselling-3 Family Counselling-4 Mental Health Counselling-5 Trauma and Violence-6 Others-99');
                $table->string('type_of_counselling_offered_other')->nullable()->comment('	If Others, Please Specify');
                $table->string('counselling_medium')->nullable();
                $table->string('other_counselling_medium')->nullable();
                $table->string('duration_of_counselling')->nullable();
                $table->string('key_concerns_discussed')->nullable();
                $table->string('follow_up_date')->nullable();
                $table->string('remarks')->nullable();
                $table->smallInteger('status')->default(0)->comment('0 = Not Assigned, 1 = Pending, 2 = Accept, 3 = Reject');
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
        Schema::dropIfExists('outreach_counselling_services');
    }
};