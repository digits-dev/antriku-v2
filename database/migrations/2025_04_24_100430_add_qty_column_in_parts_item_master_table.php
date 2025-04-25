<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyColumnInPartsItemMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parts_item_master', function (Blueprint $table) {
            $table->bigInteger('qty')->default(0)->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parts_item_master', function (Blueprint $table) {
            $table->dropColumn('qty');
        });
    }
}
