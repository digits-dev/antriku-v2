<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderReceivedDateColumnInReturnsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->string('order_received_date', 20)->nullable()->after('das_reference');
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
            $table->dropColumn('order_received_date');
        });
    }
}
