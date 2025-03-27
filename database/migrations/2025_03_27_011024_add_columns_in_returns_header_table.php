<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInReturnsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->string('unit_type')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
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
            $table->dropColumn('unit_type');
            $table->dropColumn('country');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('barangay');
        });
    }
}
