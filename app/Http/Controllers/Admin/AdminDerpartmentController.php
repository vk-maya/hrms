<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class AdminDerpartmentController extends Controller
{
    public function departmentscreate(){
    
        return view('admin.branch.departments');
    }
    public function departmentsstore(Request $request){
        $data = new Department();
        $data->department_name = $request->department;
        $data->status = $request->status;
        $data->save();
        return redirect('/admin/dashboard');
    }
}
