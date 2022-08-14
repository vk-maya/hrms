<?php

namespace Database\Seeders;

use App\Models\Admin\Session;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $from= date("Y");
        $to = $from+1;
        $to = $to."-03-31";
        $from = $from."-04-01";
        Session::insert([
            "from" => $from,
            "to" =>$to,
            "status" =>1,
        ]);
    }
}
