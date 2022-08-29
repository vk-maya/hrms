<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultiToMonthleavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthleaves', function (Blueprint $table) {
            //
            $table->integer('working_day')->after('other')->default(0);
            $table->integer('carry_pl_leave')->after('anualLeave')->default(0);
            $table->integer('carry_sick_leave')->after('sickLeave')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthleaves', function (Blueprint $table) {
            //
        });
    }
}
