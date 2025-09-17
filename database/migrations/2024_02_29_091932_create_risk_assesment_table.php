<?php

use App\Models\Outreach\RiskAssessment;
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
        if (Schema::hasTable('risk_assesment')) {
            $data = DB::table('risk_assesment')->get();
            mediaOperations(BACKUP_PATH . 'risk_assesment' . EXT_JSON, $data->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            Schema::disableForeignKeyConstraints();
            Schema::drop('risk_assesment');
        }

        if (!Schema::hasTable('outreach_risk_assesment')) {
            Schema::create('outreach_risk_assesment', function (Blueprint $table) {
                $table->bigIncrements('risk_assesment_id');
                $table->foreignId('profile_id')->nullable()->index()->constrained('outreach_profile')->references('profile_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('client_type_id')->nullable()->index()->constrained('client_type_master')->references('client_type_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->index()->constrained('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->boolean('provided_client_with_information')->nullable()->comment('Yes-1 No-2');
                $table->string('types_of_information')->nullable();
                $table->date('date_of_risk_assessment');
                $table->integer('had_sex_without_a_condom')->comment('Yes-1 No-2 Prefer not to say-3 Question did not ask-4');
                $table->integer('shared_needle_for_injecting_drugs')->comment('Yes-1 No-2 Prefer not to say-3 Question did not ask-4');
                $table->integer('sexually_transmitted_infection')->comment('Yes-1 No-2 Prefer not to say-3 Question did not ask-4');
                $table->integer('sex_with_more_than_one_partners')->comment('Yes-1 No-2 Prefer not to say-3 Question did not ask-4');
                $table->integer('had_chemical_stimulantion_or_alcohol_before_sex')->comment('Yes-1 No-2 Prefer not to say-3 Question did not ask-4');
                $table->integer('had_sex_in_exchange_of_goods_or_money')->comment('Yes-1 No-2 Prefer not to say-3 Question did not ask-4');
                $table->string('other_reason_for_hiv_test')->nullable();
                $table->integer('risk_category')->nullable()->comment('High-1 Medium-2 Low-3');
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
        Schema::dropIfExists('outreach_risk_assesment');
    }
};