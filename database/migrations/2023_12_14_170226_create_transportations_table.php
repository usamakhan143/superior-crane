<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticketNumber');
            $table->string('pickupAddress');
            $table->string('deliveryAddress');
            $table->string('billingAddress');
            $table->string('TimeIn');
            $table->string('TimeOut');
            $table->string('notes');
            $table->string('specialInstructionsForJobNumber');
            $table->string('poNumber');
            $table->string('specialInstructionsForPoNumber');
            // Site Contact
            $table->string('siteContactName');
            $table->string('specialInstructionsForSiteContactName');
            $table->string('siteContactNumber');
            $table->string('specialInstructionsForSiteContactNumber');
            // Shipper
            $table->string('shipperName');
            $table->string('shipperDate');
            $table->string('shipperTimeIn');
            $table->string('shipperTimeOut');
            // Pickup Driver
            $table->string('pickupDriverName');
            $table->string('pickupDriverDate');
            $table->string('pickupDriverTimeIn');
            $table->string('pickupDriverTimeOut');
            // Customer
            $table->string('customerName');
            $table->string('customerDate');
            $table->string('customerTimeIn');
            $table->string('customerTimeOut');
            $table->string('customerEmail');
            $table->integer('signaturesLeft');
            $table->boolean('isDraft');
            $table->integer('job_id');
            $table->integer('account_id');
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
        Schema::dropIfExists('transportations');
    }
}
