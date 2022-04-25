<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_id');
            $table->string('client_idd');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('rate');
            $table->string('duration');
            $table->string('priority');
            $table->integer('description');
            $table->integer('team');
            $table->string('status');
            $table->string('image');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_models');
    }
}
