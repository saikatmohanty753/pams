<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsRemovedToAssignObserverUsersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_observer_users_details', function (Blueprint $table) {
            $table->tinyInteger('is_removed')->default(0)->nullable();
            $table->timestamp('removed_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_observer_users_details', function (Blueprint $table) {
            $table->dropColumn('is_removed');
            $table->dropColumn('removed_date');
        });
    }
}
