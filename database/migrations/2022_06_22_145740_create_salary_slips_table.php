<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('monthly')->nullable();
            $table->integer('status')->default('0');
            $table->string('basic_salary');
            $table->string('tds')->nullable();
            $table->string('da')->nullable();
            $table->string('est')->nullable();
            $table->string('hra')->nullable();
            $table->string('pf')->nullable();
            $table->string('conveyance')->nullable();
            $table->string('Prof_tax')->nullable();
            $table->string('allowance')->nullable();
            $table->string('Labour_welf')->nullable();
            $table->string('Medical_allow')->nullable();
            $table->string('other')->nullable();
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
        Schema::dropIfExists('salary_slips');
    }
}
