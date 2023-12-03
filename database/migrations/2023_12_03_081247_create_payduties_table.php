<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaydutiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payduties', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('location');
            $table->string('startTime');
            $table->string('finishTime');
            $table->string('totalHours');
            $table->string('officer');
            $table->string('officerName');
            $table->string('division');
            $table->string('email');
            $table->bigInteger('account_id');
            $table->bigInteger('rigger_id');
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
        Schema::dropIfExists('payduties');
    }
}
