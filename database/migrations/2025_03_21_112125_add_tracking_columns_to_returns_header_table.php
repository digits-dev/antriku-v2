<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackingColumnsToReturnsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->integer('print_receiving_form_by')->nullable()->after('level6_personnel_edited');
            $table->timestamp('print_receiving_form_at')->nullable()->after('print_receiving_form_by');
            $table->integer('diagnose_by')->nullable()->after('print_receiving_form_at');
            $table->timestamp('diagnose_at')->nullable()->after('diagnose_by');
            $table->integer('approved_by')->nullable()->after('diagnose_at');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->integer('rejected_by')->nullable()->after('approved_at');
            $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            $table->integer('for_callout_by')->nullable()->after('rejected_at');
            $table->timestamp('for_callout_at')->nullable()->after('for_callout_by');
            $table->integer('spare_parts_received_by')->nullable()->after('for_callout_at');
            $table->timestamp('spare_parts_received_at')->nullable()->after('spare_parts_received_by');
            $table->integer('repair_completed_by')->nullable()->after('spare_parts_received_at');
            $table->timestamp('repair_completed_at')->nullable()->after('repair_completed_by');
            $table->integer('paid_by')->nullable()->after('repair_completed_at');
            $table->timestamp('paid_at')->nullable()->after('paid_by');
            $table->integer('shipped_by')->nullable()->after('paid_at');
            $table->timestamp('shipped_at')->nullable()->after('shipped_by');
            $table->integer('for_customer_payment_by')->nullable()->after('shipped_at');
            $table->timestamp('for_customer_payment_at')->nullable()->after('for_customer_payment_by');
            $table->integer('replacement_part_paid_by')->nullable()->after('for_customer_payment_at');
            $table->timestamp('replacement_part_paid_at')->nullable()->after('replacement_part_paid_by');
            $table->integer('for_call_out_good_unit_by')->nullable()->after('replacement_part_paid_at');
            $table->timestamp('for_call_out_good_unit_at')->nullable()->after('for_call_out_good_unit_by');
            $table->integer('for_parts_ordering_by')->nullable()->after('for_call_out_good_unit_at');
            $table->timestamp('for_parts_ordering_at')->nullable()->after('for_parts_ordering_by');
            $table->integer('print_releasing_form_by')->nullable();
            $table->timestamp('print_releasing_form_at')->nullable();
            $table->integer('cancelled_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->integer('closed_by')->nullable();
            $table->timestamp('close_at')->nullable();
            $table->integer('escalated_by')->nullable();
            $table->timestamp('escalated_at')->nullable();
            $table->integer('completed_by')->nullable();
            $table->timestamp('completed_at')->nullable();
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
            $table->dropColumn([
                'print_receiving_form_by', 'print_receiving_form_at',
                'diagnose_by', 'diagnose_at',
                'approved_by', 'approved_at',
                'rejected_by', 'rejected_at',
                'for_callout_by', 'for_callout_at',
                'spare_parts_received_by', 'spare_parts_received_at',
                'repair_completed_by', 'repair_completed_at',
                'paid_by', 'paid_at',
                'shipped_by', 'shipped_at',
                'for_customer_payment_by', 'for_customer_payment_at',
                'replacement_part_paid_by', 'replacement_part_paid_at',
                'for_call_out_good_unit_by', 'for_call_out_good_unit_at',
                'for_parts_ordering_by', 'for_parts_ordering_at',
                'print_releasing_form_by', 'print_releasing_form_at',
                'cancelled_by', 'cancelled_at',
                'closed_by', 'closed_at',
                'escalated_by',
                'escalated_at'
            ]);
        });
    }
}