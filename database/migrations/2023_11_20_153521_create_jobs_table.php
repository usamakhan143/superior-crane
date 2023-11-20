<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_number');
            $table->string('client_name');
            $table->string('job_date');
            $table->string('job_time');
            $table->string('address');
            $table->string('equipment_used');
            $table->bigInteger('rigger_assigned');
            $table->string('supplier_name');
            $table->string('notes');
            $table->string('enter_by');
            $table->string('status_code');
            $table->boolean('is_scci');
            $table->boolean('is_rigger');
            $table->string('pdf_rigger')->nullable();
            $table->boolean('is_transportation');
            $table->string('pdf_transportation')->nullable();
            $table->bigInteger('account_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
