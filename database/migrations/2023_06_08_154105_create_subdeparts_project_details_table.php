<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdepartsProjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_depts_project_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('dept_id')->unsigned()->nullable();
            $table->integer('sub_dept_id')->unsigned()->nullable();
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
        Schema::dropIfExists('subdeparts_project_details');
    }
}
