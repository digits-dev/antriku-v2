<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPdfFilesTrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_files_tracker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pdf_file_name')->unique();
            $table->integer('save_drive')->default(0);
            $table->integer('send_email')->default(0);
            $table->integer('save_drive_by')->nullable();
            $table->integer('send_email_by')->nullable();
            $table->timestamp('save_drive_at')->nullable();
            $table->timestamp('send_email_at')->nullable();
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
        Schema::dropIfExists('pdf_files_tracker');
    }
}
