<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;

class AdminDerpartmentController extends Controller
{
    public function departmentscreate($id=''){
        if($id>0){
            $edit = Department::find($id);        
        }else{
            $edit ="";
        }      
            $department = Department::all();    
        return view('admin.branch.departments',compact('department','edit'));
        
    }
    public function departmentsstore(Request $request){
        $data = new Department();
        $data->department_name = $request->department;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('admin.departments');
    }

    public function designationcreate(){
        $department = Department::all();
        $designation = Designation::all();
        return view('admin.branch.designation',compact('department','designation'));
    }

    public function designationstore(Request $request){
        $data= new Designation();
        $data->designation_name=$request->designation;
        $data->department_id=$request->department_id;
        $data->status=$request->status;
        $data->save();
        return redirect()->route('admin.designation');
    }
    public function departmentdelete($id){
        $data = Designation::where('department_id',$id)->count();
        
        if($data>0){           
            return redirect()->route('admin.departments');
        }else{
            $data = Department::find($id)->delete();
            return redirect()->route('admin.departments');
        }
    }
    public function designationdelete($id){
        $data = User::where('designation_id',$id)->count();
        
        if($data>0){           
            return redirect()->route('admin.designation');
        }else{
            $data = User::find($id)->delete();
            return redirect()->route('admin.designation');
        }
      }
}
