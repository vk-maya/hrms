<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\SalaryManagment;

class SalaryManagement extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SalaryManagment::truncate();
        SalaryManagment::insert([
            [
                'title'=>'DA',
                'type'=>'earning'
            ],
            [
                'title'=>'HRA',
                'type'=>'earning'
            ],
            [
                'title'=>'Conveyance',
                'type'=>'earning'
            ],
            [
                'title'=>'Allowance',
                'type'=>'earning'
            ],
            [
                'title'=>'Medical Allowance',
                'type'=>'earning'
            ],
            [
                'title'=>"TDS",
                'type'=>'deduction'
            ],
            [
                'title'=>"ESI",
                'type'=>'deduction'
            ],
            [
                'title'=>"PF",
                'type'=>'deduction'
            ],
            [
                'title'=>"Prof Tax",
                'type'=>'deduction'
            ],
            [
                'title'=>"Labour Welfare",
                'type'=>'deduction'
            ],
            [
                'title'=>"Others",
                'type'=>'deduction'
            ],
        ]);
    }
}
