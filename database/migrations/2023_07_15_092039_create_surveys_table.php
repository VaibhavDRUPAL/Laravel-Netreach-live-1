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
        if (!Schema::hasTable('surveys')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('surveys', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('customers')->references('id')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('platform_id')->nullable()->constrained('platforms')->onUpdate('cascade')->onDelete('cascade');
                $table->smallInteger('client_type')->default(0)->comment("1:'New Client' , 2: 'Follow Up Client'");
                $table->integer('your_age');
                $table->integer('identify_yourself');
                $table->text('identify_others')->nullable()->collation('utf8_general_ci');
                $table->text('sexually')->nullable()->collation('utf8_general_ci');
                $table->text('hiv_infection')->nullable()->collation('utf8_general_ci');
                $table->text('risk_level')->nullable()->collation('utf8_general_ci');
                $table->text('services_required')->nullable()->collation('utf8_general_ci');
                $table->text('hiv_test')->nullable()->collation('utf8_general_ci');
                $table->text('survey_details')->nullable()->collation('utf8_general_ci');
                $table->text('target_population')->nullable()->collation('utf8_general_ci');
                $table->smallInteger('flag')->default(0);
                $table->smallInteger('manual_flag')->default(0)->comment("0:Normal,1:Manual Flag");
                $table->smallInteger('survey_co_flag')->default(0)->comment("0:No Counseling, 1: counseling");
                $table->smallInteger('po_status')->default(0)->comment("0: Pending, 1:Approve, 2:Reject");
                $table->text('po_commented_on')->nullable()->comment('PO Comment by Approve and Reject Case Datetime')->collation('utf8_general_ci');
                $table->integer('po_status_created_by')->default(0)->comment('Save PO ID');
                $table->string('po_status_created_on')->nullable()->collation('utf8_general_ci')->comment('When PO Action Entery save Date time');
                $table->integer('survey_manual_vn_id')->default(0)->comment('Create Manual Survey by Vn id');
                $table->string('hiv_infection_new')->nullable();
                $table->dateTime('created_at');
                $table->dateTime('updated_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('surveys');
    }
};