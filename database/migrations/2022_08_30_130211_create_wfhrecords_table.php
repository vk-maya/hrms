<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWfhrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfhrecords', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id')->nullable();
            $table->integer('user_id');
            $table->integer('admin_id');
            $table->integer('wfh_id');
            $table->date('from');
            $table->date('to');
            $table->float('day');
            $table->string('task');
            $table->integer('status')->default(2);
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
        Schema::dropIfExists('wfhrecords');
    }
}
