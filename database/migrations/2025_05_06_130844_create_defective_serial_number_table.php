<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectiveSerialNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defective_serial_number', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('returns_header_id')->nullable();
            $table->string('defective_kbb_name', 255)->nullable();
            $table->string('defective_serial_number', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defective_serial_number');
    }
}