<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_order_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_order_header_id');
            $table->bigInteger('parts_item_master_id');
            $table->string('qty');
            $table->string('order_status')->default('Awaiting Apple Stock (Buffer)');
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
        Schema::dropIfExists('stock_order_lines');
    }
}
