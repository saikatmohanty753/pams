<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignObserverUsersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_observer_users_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->integer('task_detail_id')->nullable();
            $table->integer('observer_user_id')->nullable();
            $table->integer('add_by_user_id')->nullable();
            $table->integer('status')->nullable();
            $table->tinyInteger('is_active')->default(0)->nullable();
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
        Schema::dropIfExists('assign_observer_users_details');
    }
}
