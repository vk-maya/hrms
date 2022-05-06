<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->onDelete('cascade');
            $table->foreignId('client_id')->onDelete('cascade');
            $table->string('name');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('rate');
            $table->string('duration');
            $table->string('priority');
            $table->string('description');
            $table->string('image');
            $table->integer('status');
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
        Schema::dropIfExists('projects');
    }
}
