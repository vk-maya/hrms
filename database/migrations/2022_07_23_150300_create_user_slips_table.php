<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_slips', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_salaryID');
            $table->string('slip_month');
            $table->string('payslip_number');
            $table->string('salary_month');
            $table->float('net_salary');
            $table->float('monthly_netsalary');
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
            $table->float('leave_deduction')->nullable();
            $table->float('paysalary')->nullable();
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
        Schema::dropIfExists('user_slips');
    }
}
