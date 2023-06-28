<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDobToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->after('email')->nullable();
            $table->string('mobile_no')->after('dob')->nullable();
            $table->string('alt_mobile_no')->after('mobile_no')->nullable();
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
            $table->date('dob')->after('email')->nullable();
            $table->string('mobile_no')->after('dob')->nullable();
            $table->string('alt_mobile_no')->after('mobile_no')->nullable();
        });
    }
}
