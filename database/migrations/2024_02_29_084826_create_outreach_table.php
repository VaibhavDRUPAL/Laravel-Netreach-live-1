<?php

use App\Models\Outreach\Profile;
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
        if (Schema::hasTable('outreach')) {
            $data = DB::table('outreach')->get();
            mediaOperations(BACKUP_PATH . 'outreach' . EXT_JSON, $data->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            Schema::disableForeignKeyConstraints();
            Schema::drop('outreach');
        }

        if (!Schema::hasTable('outreach_profile')) {
            Schema::create('outreach_profile', function (Blueprint $table) {
                $table->bigIncrements('profile_id');
                $table->foreignId('district_id')->nullable()->constrained('district_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('state_id')->nullable()->constrained('state_master')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('platform_id')->nullable()->constrained('platforms')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('gender_id')->nullable()->index()->constrained('gender_master')->references('gender_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('target_id')->nullable()->index()->constrained('target_population_master')->references('target_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('response_id')->nullable()->index()->constrained('client_response_master')->references('response_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('client_type_id')->nullable()->index()->constrained('client_type_master')->references('client_type_id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->index()->constrained('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('mention_platform_id')->nullable()->constrained('platforms')->onUpdate('cascade')->onDelete('cascade');
                $table->integer('region_id');
                $table->string('unique_serial_number')->nullable()->unique()->comment('Unique serial number Combination of VN code and serial number');
                $table->integer('age', false)->nullable();
                $table->boolean('age_not_disclosed')->default(false);
                $table->string('uid')->nullable();
                $table->date('registration_date');
                $table->text('location')->nullable();
                $table->string('other_platform')->nullable()->comment('If Others, Please Specify');
                $table->string('profile_name');
                $table->string('other_gender')->nullable()->comment('If Others, Please Specify');
                $table->string('others_target_population')->nullable();
                $table->string('virtual_platform')->nullable()->comment('Do you use any other virtual platform (social media or dating App) for seeking partner? Yes-1 No-2 Not disclosed-3');
                $table->string('others_mentioned')->nullable();
                $table->boolean('reached_out')->nullable()->comment('Yes-1 No-0');
                $table->string('phone_number')->nullable()->comment('Phone number (WhatsApp number)');
                $table->date('follow_up_date')->nullable();
                $table->boolean('shared_website_link')->nullable();
                $table->text('remarks')->nullable();
                $table->smallInteger('status')->default(0)->comment('0 = Not Assigned, 1 = Pending, 2 = Accept, 3 = Reject');
                $table->string('in_referral')->nullable();
                $table->string('referral_other')->nullable();
                $table->string('purpose_val')->nullable();
                $table->string('purpose_other')->nullable();
                $table->string('comment');
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
        Schema::dropIfExists('outreach_profile');
    }
};