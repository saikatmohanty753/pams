<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeletedToReportingDesigDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reporting_desig_details', function (Blueprint $table) {
            $table->tinyInteger('is_delete')->after('is_active')->default(0)->nullable();
            $table->timestamp('deleted_date')->after('is_delete')->nullable();
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
