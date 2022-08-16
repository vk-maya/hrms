<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->time('work_time')->default("00:00");
            $table->date('date');
            $table->integer('day');
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->string('attendance');
            $table->integer('status')->default(0);
            // $table->date('passdate')->default('00-00-00');
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
        Schema::dropIfExists('attendances');
    }
}
