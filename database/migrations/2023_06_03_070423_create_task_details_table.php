<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->unsigned()->nullable()->default(12);
            $table->integer('created_by')->unsigned()->nullable()->default(12);
            $table->string('task_subject', 255)->nullable();
            $table->text('task_description')->nullable();
            $table->text('task_remark')->nullable();
            $table->tinyInteger('is_active')->default(0)->nullable();
            $table->tinyInteger('is_complete')->default(0)->nullable();
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
        Schema::dropIfExists('task_details');
    }
}
