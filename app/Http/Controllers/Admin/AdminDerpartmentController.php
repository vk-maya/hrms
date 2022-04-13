<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Designation;

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
    public function designationcreate(){
        $department = Department::all(); 
        return view('admin.branch.designation',compact('department'));
    }
    public function designationstore(Request $request){
    //    dd($request->toArray());
        $data= new Designation();
        $data->designation_name=$request->designation;
        $data->department_id=$request->department_id;
        $data->status=$request->status;
        $data->save();

        return redirect('/admin/dashboard');

    }
}
