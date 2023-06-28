<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportingDesigDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporting_desig_details', function (Blueprint $table) {
            $table->id();
            $table->integer('designation_id')->nullable();
            $table->integer('reporting_designation_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->tinyInteger('is_active')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reporting_desig_details');
    }
}
