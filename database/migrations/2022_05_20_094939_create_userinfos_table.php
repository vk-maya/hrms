<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userinfos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('nationality')->nullable();
            $table->string('maritalStatus')->nullable();
            $table->string('noOfChildren')->nullable();         
            $table->string('bankname')->nullable();
            $table->bigInteger('bankAc')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('pan')->nullable();
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
        Schema::dropIfExists('userinfos');
    }
}
