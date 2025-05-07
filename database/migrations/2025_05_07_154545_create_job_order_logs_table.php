<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('returns_header_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('transacted_by')->nullable();
            $table->timestamp('transacted_at')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_order_logs');
    }
}