<?php

use App\Models\Outreach\PLHIV;
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
        if (Schema::hasTable('plhiv')) {
            $data = DB::table('plhiv')->get();
            mediaOperations(BACKUP_PATH . 'plhiv' . EXT_JSON, $data->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            Schema::disableForeignKeyConstraints();
            Schema::drop('plhiv');
        }

        if (!Schema::hasTable('outreach_plhiv')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('outreach_plhiv', function (Blueprint $table) {
                $table->bigIncrements('plhiv_id');
                $table->foreignId('profile_id')->nullable()->index()->constrained('outreach_profile')->references('profile_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('referral_service_id')->nullable()->index()->constrained('outreach_referral_service')->references('referral_service_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('client_type_id')->nullable()->index()->constrained('client_type_master')->references('client_type_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->index()->constrained('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->date('registration_date')->nullable();
                $table->string('pid_or_other_unique_id_of_the_service_center')->nullable();
                $table->date('date_of_confirmatory')->nullable();
                $table->date('date_of_art_reg')->nullable();
                $table->string('pre_art_reg_number')->nullable();
                $table->string('date_of_on_art')->nullable();
                $table->string('on_art_reg_number')->nullable();
                $table->string('type_of_facility_where_treatment_sought')->nullable();
                $table->foreignId('art_state_id')->nullable()->index()->constrained('state_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('art_district_id')->nullable()->index()->constrained('district_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('art_center_id')->nullable()->index()->constrained('centre_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->text('remarks')->nullable();
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
        Schema::dropIfExists('outreach_plhiv');
    }
};