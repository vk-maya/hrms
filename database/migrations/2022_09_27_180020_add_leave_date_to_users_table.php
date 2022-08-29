<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeaveDateToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->date('resignDate')->after('joiningDate')->nullable('0000-00-00');
            $table->date('noticeDate')->after('resignDate')->nullable('0000-00-00');
            $table->string('type')->after('noticeDate')->nullable('0000-00-00');
            $table->float('experience')->after('type')->nullable('0000-00-00');
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
