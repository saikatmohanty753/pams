<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDepartmentIdInReportingDesigDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reporting_desig_details', function (Blueprint $table) {
            $table->renameColumn('department_id','dept_id');
            $table->renameColumn('reporting_designation_id','reporting_id');
            $table->renameColumn('designation_id','desig_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reporting_desig_details', function (Blueprint $table) {
            //
        });
    }
}
