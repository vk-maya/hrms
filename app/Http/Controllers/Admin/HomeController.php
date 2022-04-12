<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;

class HomeController extends Controller
{
public function create(){
    return view('admin.designation');
}
public function store(Request $request){
    // dd($request->toArray());
    $data = new Designation();
    $data->name = $request->designation;
    $data->status = $request->status;
    $data->save();
    return redirect('/admin/dashboard');
}

public function employeecreate(){
    
    return view('admin.employees.employees');
}
}
