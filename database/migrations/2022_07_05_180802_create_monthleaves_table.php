<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthleavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthleaves', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('from');
            $table->string('to');
            $table->float('anualLeave');
            $table->float('sickLeave');
            $table->float('apprAnual')->nullable();
            $table->float('apprSick')->nullable();
            $table->float('other')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('monthleaves');
    }
}
