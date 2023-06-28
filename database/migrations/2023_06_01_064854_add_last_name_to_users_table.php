<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastNameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->Integer('department_id')->after('id')->nullable();
            $table->Integer('designation_id')->after('id')->nullable();
            $table->Integer('reporting_designation_id')->after('id')->nullable();
            $table->Integer('user_type_id')->after('id')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('emp_code')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
