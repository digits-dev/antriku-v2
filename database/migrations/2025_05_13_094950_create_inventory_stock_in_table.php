<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryStockInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_stock_in', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parts_item_master_id');
            $table->string('reference_number', 30)->nullable();
            $table->string('qty');
            $table->string('stock_in_type', 50)->default('Manual Stock In')->nullable();
            $table->string('stock_in_status', 30)->default('Received')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_stock_in');
    }
}
