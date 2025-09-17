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
        Schema::table('book_appinment_master', function (Blueprint $table) {
            $table->date('date_of_accessing_service')->nullable();
            $table->integer('access_service')->nullable()->comment('Did the client access the service?');
            $table->integer('applicable_for_hiv_test')->nullable()->comment('Screening-1 Confirmatory-2');
            $table->foreignId('client_type_id')->nullable()->index()->constrained('client_type_master')->references('client_type_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('service_type_id')->comment('If response is 5 refer to NETREACH counsellor If asked for more than one service please record it in the next row')->nullable()->index()->constrained('service_type_master')->references('service_type_id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('counselling_service')->nullable()->comment('Yes-1 No-2');
            $table->string('prevention_programme')->nullable()->comment('Ever had a HIV test as part of any Targeted Intervention programme or other HIV prevention programme? TI-1 Other HIV prevention programme-2 No-3 Not availing service in TI since last 6 months-4');
            $table->smallInteger('status')->default(0)->comment('0 = Not Assigned, 1 = Pending, 2 = Accept, 3 = Reject');
            $table->foreignId('sti_service_id')->nullable()->index()->constrained('sti_service_master')->references('sti_service_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('other_sti_service')->nullable();
            $table->integer('pid_or_other_unique_id_of_the_service_center')->nullable()->comment('PID or other unique ID of the client provided at the service centre');
            $table->integer('outcome_of_the_service_sought')->nullable()->comment('If tested for HIV/STI this is a mandatory column Outcome of the service sought Reactive-1 Non-reactive-2 Not disclosed-3 If non-reactive follow up after 6 months');
            $table->foreignId('reason_id')->nullable()->index()->constrained('reason_for_not_accessing_service_master')->references('reason_id')->onUpdate('cascade')->onDelete('cascade');
            $table->text('other_not_access')->nullable()->comment('If others, please specify');
            $table->date('follow_up_date')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('educational_attainment_id')->nullable()->index()->constrained('educational_attainment_master')->references('educational_attainment_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('occupation_id')->nullable()->index()->constrained('primary_occupation_master')->references('occupation_id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_appinment_master', function (Blueprint $table) {
            $table->dropColumn('date_of_accessing_service');
            $table->dropColumn('access_service');
            $table->dropColumn('applicable_for_hiv_test');
            $table->dropConstrainedForeignId('client_type_id');
            $table->dropConstrainedForeignId('service_type_id');
            $table->dropColumn('counselling_service');
            $table->dropColumn('prevention_programme');
            $table->dropColumn('status');
            $table->dropConstrainedForeignId('sti_service_id');
            $table->dropColumn('other_sti_service');
            $table->dropColumn('pid_or_other_unique_id_of_the_service_center');
            $table->dropColumn('outcome_of_the_service_sought');
            $table->dropConstrainedForeignId('reason_id');
            $table->dropColumn('other_not_access');
            $table->dropColumn('follow_up_date');
            $table->dropColumn('remarks');
            $table->dropConstrainedForeignId('educational_attainment_id');
            $table->dropConstrainedForeignId('occupation_id');
        });
    }
};
