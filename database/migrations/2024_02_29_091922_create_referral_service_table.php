<?php

use App\Models\Outreach\ReferralService;
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
        if (Schema::hasTable('referral_service')) {
            $data = DB::table('referral_service')->get();
            mediaOperations(BACKUP_PATH . 'referral_service' . EXT_JSON, $data->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            Schema::disableForeignKeyConstraints();
            Schema::drop('referral_service');
        }

        if (!Schema::hasTable('outreach_referral_service')) {
            Schema::create('outreach_referral_service', function (Blueprint $table) {
                $table->bigIncrements('referral_service_id');
                $table->foreignId('profile_id')->nullable()->index()->constrained('outreach_profile')->references('profile_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('client_type_id')->nullable()->index()->constrained('client_type_master')->references('client_type_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('educational_attainment_id')->nullable()->index()->constrained('educational_attainment_master')->references('educational_attainment_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('occupation_id')->nullable()->index()->constrained('primary_occupation_master')->references('occupation_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('ti_service_id')->nullable()->index()->constrained('ti_service_master')->references('ti_service_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('service_type_id')->comment('If response is 5 refer to NETREACH counsellor If asked for more than one service please record it in the next row')->nullable()->index()->constrained('service_type_master')->references('service_type_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->index()->constrained('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('netreach_uid_number')->nullable();
                $table->string('other_service_type')->nullable()->comment('If Other, Please specify service type');
                $table->string('provided_client_with_information_bcc')->nullable()->comment('Provided the client with Information and BCC Yes-1 No- 2');
                $table->string('bcc_provided', 2)->nullable()->comment('If Yes, types of BCC provided');
                $table->string('other_services', 2)->nullable()->comment('If others, please specify');
                $table->string('other_ti_services', 2)->nullable()->comment('If others, please specify');
                $table->string('other_referred_service')->nullable()->comment('If others, please specify');
                $table->integer('counselling_service')->nullable()->comment('Yes-1 No-2');
                $table->string('prevention_programme')->nullable()->comment('Ever had a HIV test as part of any Targeted Intervention programme or other HIV prevention programme? TI-1 Other HIV prevention programme-2 No-3 Not availing service in TI since last 6 months-4');
                $table->integer('type_of_facility_where_referred')->nullable()->comment('Type of facility where referred Govt. -1 Private -2 NGO/CBO - 3 TI-4');
                $table->string('name_of_different_center')->nullable();
                $table->date('referral_date')->nullable();
                $table->foreignId('referred_district_id')->nullable()->constrained('district_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('referred_state_id')->nullable()->constrained('state_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('referral_center_id')->nullable()->index()->constrained('centre_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('type_of_facility_where_tested')->nullable()->comment('Govt. -1 Private -2 NGO/CBO - 3 TI-4');
                $table->integer('access_service')->nullable()->comment('Did the client access the service?');
                $table->string('service_accessed')->nullable()->comment('Name and Address where service accessed');
                $table->foreignId('service_accessed_center_id')->nullable()->index()->constrained('centre_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('client_access_service')->nullable()->comment('Where did the client access service?');
                $table->foreignId('test_centre_district_id')->nullable()->constrained('district_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('test_centre_state_id')->nullable()->constrained('state_master')->onUpdate('cascade')->onDelete('cascade');
                $table->date('date_of_accessing_service')->nullable();
                $table->integer('applicable_for_hiv_test')->nullable()->comment('Screening-1 Confirmatory-2');
                $table->foreignId('sti_service_id')->nullable()->index()->constrained('sti_service_master')->references('sti_service_id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('other_sti_service')->nullable();
                $table->integer('pid_or_other_unique_id_of_the_service_center')->nullable()->comment('PID or other unique ID of the client provided at the service centre');
                $table->integer('outcome_of_the_service_sought')->nullable()->comment('If tested for HIV/STI this is a mandatory column Outcome of the service sought Reactive-1 Non-reactive-2 Not disclosed-3 If non-reactive follow up after 6 months');
                $table->foreignId('reason_id')->nullable()->index()->constrained('reason_for_not_accessing_service_master')->references('reason_id')->onUpdate('cascade')->onDelete('cascade');
                $table->text('other_not_access')->nullable()->comment('If others, please specify');
                $table->date('follow_up_date')->nullable();
                $table->text('remarks')->nullable();
                $table->smallInteger('status')->default(0)->comment('0 = Not Assigned, 1 = Pending, 2 = Accept, 3 = Reject');
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('outreach_referral_service');
    }
};