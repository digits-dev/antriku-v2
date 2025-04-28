<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallOutRecorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_out_recorder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('returns_header_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('call_out_by')->nullable();
            $table->timestamp('call_out_at')->nullable();
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
        Schema::dropIfExists('call_out_recorder');
    }
}