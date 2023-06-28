<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeleteToTaskDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_details', function (Blueprint $table) {
            $table->tinyInteger('is_delete')->default(0)->nullable();
            $table->timestamp('deleted_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_details', function (Blueprint $table) {
            $table->dropColumn('is_delete');
            $table->dropColumn('deleted_date');
        });
    }
}
