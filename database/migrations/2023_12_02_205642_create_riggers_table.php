<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riggers', function (Blueprint $table) {
            $table->id();
            $table->string('specificationsAndRemarks');
            $table->string('customer');
            $table->string('location');
            $table->string('poNumber');
            $table->string('date');
            $table->string('startJob');
            $table->string('arrivalYard');
            $table->string('travelTime');
            $table->string('totalHours');
            $table->string('rating');
            $table->string('operation');
            $table->string('emailAddress');
            $table->string('notesOthers');
            $table->string('leaveYard');
            $table->string('finishJob');
            $table->string('lunch');
            $table->string('craneTime');
            $table->string('craneNumber');
            $table->string('boomLength');
            $table->string('otherEquipment');
            $table->boolean('isPayDuty');
            $table->bigInteger('ticketNumber');
            $table->bigInteger('job_id');
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
        Schema::dropIfExists('riggers');
    }
}
