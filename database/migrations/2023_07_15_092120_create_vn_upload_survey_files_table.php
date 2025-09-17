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
        if (!Schema::hasTable('vn_upload_survey_files')) {
            Schema::disableForeignKeyConstraints();
            Schema::create('vn_upload_survey_files', function (Blueprint $table) {
                $table->id();
                $table->foreignId('survey_id')->constrained('surveys')->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
                $table->date('acess_date');
                $table->string('pid')->collation('utf8_general_ci');
                $table->text('detail')->collation('utf8_general_ci');
                $table->text('file_upload')->collation('utf8_general_ci');
                $table->smallInteger('outcome')->default(0);
                $table->tinyInteger('dontshare')->default(0);
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
        Schema::dropIfExists('vn_upload_survey_files');
    }
};
