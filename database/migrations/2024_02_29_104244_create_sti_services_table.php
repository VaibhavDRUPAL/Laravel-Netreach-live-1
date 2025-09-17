<?php

use App\Models\Outreach\STIService;
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
        if (Schema::hasTable('sti_services')) {
            $data = DB::table('sti_services')->get();
            mediaOperations(BACKUP_PATH . 'sti_services' . EXT_JSON, $data->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            Schema::disableForeignKeyConstraints();
            Schema::drop('sti_services');
        }

        if (!Schema::hasTable('outreach_sti_services')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('outreach_sti_services', function (Blueprint $table) {
                $table->bigIncrements('sti_services_id');
                $table->foreignId('profile_id')->nullable()->index()->constrained('outreach_profile')->references('profile_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('client_type_id')->nullable()->index()->constrained('client_type_master')->references('client_type_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('referral_service_id')->nullable()->index()->constrained('outreach_referral_service')->references('referral_service_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('state_id')->nullable()->index()->constrained('state_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('district_id')->nullable()->index()->constrained('district_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('center_id')->nullable()->index()->constrained('centre_master')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->index()->constrained('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->date('date_of_sti');
                $table->string('pid_or_other_unique_id_of_the_service_center');
                $table->foreignId('sti_service_id')->nullable()->index()->constrained('sti_service_master')->references('sti_service_id')->onUpdate('cascade')->onDelete('cascade');
                $table->string('type_facility_where_treated')->nullable();
                $table->string('applicable_for_syphillis')->nullable();
                $table->string('other_sti_service')->nullable();
                $table->string('remarks')->nullable();
                $table->boolean('is_treated')->default(false);
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
        Schema::dropIfExists('outreach_sti_services');
    }
};