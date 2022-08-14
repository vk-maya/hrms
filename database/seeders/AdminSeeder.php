<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\SalaryManagment;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            "name" => "Admin",
            "role" => "Admin",
            "email" => "admin@gmail.com",
            "password" => Hash::make("admin@12345"),
        ]);
    }
}
