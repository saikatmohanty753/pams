<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('created_by')->nullable();
            $table->tinyInteger('is_active')->default(1)->nullable();
            $table->tinyInteger('is_deleted')->default(0)->nullable();
            $table->date('deleted_date')->nullable();
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
        Schema::dropIfExists('project_masters');
    }
}
