<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatesToProjectMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_masters', function (Blueprint $table) {
            $table->date('estimate_start_date')->after('name')->nullable();
            $table->date('estimate_end_date')->after('estimate_start_date')->nullable();
            $table->date('actual_start_date')->after('estimate_end_date')->nullable();
            $table->date('actual_end_date')->after('actual_start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_masters', function (Blueprint $table) {
            $table->date('estimate_start_date')->after('name')->nullable();
            $table->date('estimate_end_date')->after('estimate_start_date')->nullable();
            $table->date('actual_start_date')->after('estimate_end_date')->nullable();
            $table->date('actual_end_date')->after('actual_start_date')->nullable();
        });
    }
}
