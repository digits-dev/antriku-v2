<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsInReturnsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->string('customer_type', 100)->nullable();
            $table->text('inspected_model_photo')->nullable();
            $table->string('unit_type', 50)->nullable();
            $table->string('store_purchase', 150)->nullable();
            $table->string('purchace_invoice_number', 255)->nullable();
            $table->string('device_serial_number', 150)->nullable();
            $table->text('accessories_included_remarks')->nullable();
            $table->string('files_backed_up', 10)->nullable();
            $table->string('icloud_sign_out', 10)->nullable();
            $table->string('parts_replacement_cost')->nullable();
            $table->string('defective_serial_number')->nullable();
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
            $table->dropColumn('customer_type');
            $table->dropColumn('inspected_model_photo');
            $table->dropColumn('unit_type');
            $table->dropColumn('store_purchase');
            $table->dropColumn('purchace_invoice_number');
            $table->dropColumn('device_serial_number');
            $table->dropColumn('accessories_included_remarks');
            $table->dropColumn('files_backed_up');
            $table->dropColumn('icloud_sign_out');
            $table->dropColumn('parts_replacement_cost');
            $table->dropColumn('defective_serial_number');
        });
    }
}