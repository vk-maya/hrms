<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;

class EmployeesReport extends Controller
{
    public function empreport()
    {
        // $data= User::all('status',1)->with('user')->get();
        $data=  User::where('status',1)->with('userDesignation')->get();
        // dd($data->toarray());
        return view('admin.report.leavereport',compact('data'));
    }
}
