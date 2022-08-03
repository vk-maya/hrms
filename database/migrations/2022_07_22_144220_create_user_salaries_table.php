<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->float('net_salary');
            $table->date('joiningDate')->nullable();
            $table->float('monthly')->nullable();
            $table->integer('status')->default('0');
            $table->float('increment')->nullable();
            $table->float('basic_salary');
            $table->float('tds')->nullable();
            $table->float('da')->nullable();
            $table->float('esi')->nullable();
            $table->float('hra')->nullable();
            $table->float('pf')->nullable();
            $table->float('conveyance')->nullable();
            $table->float('prof_tax')->nullable();
            $table->float('allowance')->nullable();
            $table->float('labour_welfare')->nullable();
            $table->float('medical_allowance')->nullable();
            $table->float('others')->nullable();
            $table->float('tEarning')->nullable();
            $table->float('tDeducation')->nullable();
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
        Schema::dropIfExists('user_salaries');
    }
}
