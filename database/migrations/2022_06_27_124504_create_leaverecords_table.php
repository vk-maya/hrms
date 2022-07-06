<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaverecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaverecords', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id')->nullable();
            $table->integer('leave_id');
            $table->integer('user_id');
            $table->string('type_id');
            $table->date('from');
            $table->date('to');
            $table->float('day');
            $table->string('reason');
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
        Schema::dropIfExists('leaverecords');
    }
}
