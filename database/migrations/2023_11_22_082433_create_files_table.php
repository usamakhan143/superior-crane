<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_url');
            $table->string('base_url');
            $table->string('file_type');
            $table->string('file_ext_type');
            $table->integer('job_id');
            $table->integer('account_id');
            $table->integer('rigger_id');
            $table->integer('transportation_id');
            $table->integer('payduty_id');
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
        Schema::dropIfExists('files');
    }
}
