<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserleaveYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userleave_years', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('session_id')->nullable();
            $table->string('basicAnual')->nullable();
            $table->float('basicSick')->nullable();
            $table->float('netSick')->nullable();
            $table->float('netAnual')->nullable();
            $table->float('other')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('userleave_years');
    }
}
