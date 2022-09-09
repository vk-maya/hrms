<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlsickToMonthleavesTable extends Migration
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
            $table->float('monthpl')->after('anualLeave')->default(0);
            $table->float('monthsick')->after('sickLeave')->default(0);
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
