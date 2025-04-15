<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAirwaybillToReturnsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->string('inspected_model_photo')->nullable()->after('summary_of_concern');
            $table->string('other_inclusion')->nullable()->after('inspected_model_photo');
            $table->string('invoice')->nullable()->after('parts_replacement_cost');
            $table->string('airwaybill_tn')->nullable()->after('receipt');
            $table->string('airwaybill_upload')->nullable()->after('airwaybill_tn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->dropColumn(['inspected_model_photo','other_inclusion','invoice','airwaybill_tn', 'airwaybill_upload',]);
        });
    }
}