<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToReturnsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->longText('parts_replacement_cost')->nullable()->after('other_remarks');
            $table->integer('call_out_mail_in_by')->nullable()->after('technician_assigned_at');
            $table->timestamp('call_out_mail_in_at')->nullable()->after('call_out_mail_in_by');
            $table->timestamp('mail_in_shipped_by')->nullable()->after('call_out_mail_in_at');
            $table->timestamp('mail_in_shipped_at')->nullable()->after('mail_in_shipped_by');

            $table->integer('ongoing_repair_by')->nullable();
            $table->timestamp('ongoing_repair_at')->nullable();
            $table->integer('pending_spare_parts_by')->nullable();
            $table->timestamp('pending_spare_parts_at')->nullable();
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
            $table->dropColumn(['parts_replacement_cost', 'call_out_mail_in_by', 'call_out_mail_in_at', 'mail_in_shipped_by', 'mail_in_shipped_at']);
        });
    }
}