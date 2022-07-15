<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        Setting::truncate();
        $setting =  [
            ["title" => "description",],
            ["title" => "Contact",],
            [ "title" => "Address",],
            [ "title" => "country",],
            [ "title" => "state",],
            ["title" => "city",],
            ["title" => "Postal",],
            ["title" => "Email",],
            ["title" => "Number",],
            ["title" => "Website",],
            ["title" => "basic_salary",],
            ["title" => "da",],
            ["title" => "hra",],
            ["title" => "conveyance",],
            ["title" => "allowance",],
            ["title" => "Medical_allow",],
            ["title" => "tds",],
            ["title" => "est",],
            ["title" => "pf", ],
            ["title" => "Prof_tax", ],
            ["title" => "Labour_welf",],
            ["title" => "other",],
        ];
        Setting::insert($setting);
    }
}
