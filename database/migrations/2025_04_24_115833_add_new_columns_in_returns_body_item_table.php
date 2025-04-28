<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsInReturnsBodyItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_body_item', function (Blueprint $table) {
            $table->bigInteger('qty')->default(0)->after('date_ordered');
            $table->text('qty_status', 30)->after('qty');
            $table->bigInteger('item_parts_id')->after('qty_status');
            $table->enum('item_spare_additional_type', ['Additional-Standard', 'Additional-Required-Pending', 'Additional-Required-Yes', 'Additional-Required-No'])->default('Additional-Standard')->after('item_parts_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('returns_body_item', function (Blueprint $table) {
            $table->dropColumn('qty');
            $table->dropColumn('qty_status');
            $table->dropColumn('item_parts_id');
        });
    }
}
