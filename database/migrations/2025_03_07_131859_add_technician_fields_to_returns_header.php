<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTechnicianFieldsToReturnsHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('returns_header', function (Blueprint $table) {
            $table->string('case_status')->nullable()->after('warranty_status');
            $table->integer('lead_technician_id')->nullable()->after('level6_personnel_edited');
            $table->integer('technician_id')->nullable()->after('lead_technician_id');
            $table->timestamp('technician_assigned_at')->nullable()->after('technician_id');
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
            $table->dropColumn(['case','lead_technician_id', 'technician_id', 'technician_assigned_at']);
        });
    }
}