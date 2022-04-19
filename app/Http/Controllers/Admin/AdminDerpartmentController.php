<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;

class AdminDerpartmentController extends Controller
{
    public function departmentscreate(Request $request){
        if($request->id >0){
            // dd($request->id);
            $edit = Department::find($request->id);
            return response()->json(['edit' => $edit]);
        
        }else{
            $department = Department::all();
            return view('admin.branch.departments',compact('department'));
        }              
    }  
    public function departmentsstore(Request $request){
        // dd($request->toArray());
        if($request->has('id')){
            $data = Department::find($request->id);
            
        }else{
            $data = new Department();
        }
        $data->department_name = $request->department;
        $data->status = ($request->status == '1')? 1 : 0;
        $data->save();
        return redirect()->route('admin.departments');
    }

    public function departmentsstatus(Request $request){
        $data = Department::find($request->id);
        if($data->status == 1){
            $data->status= 0;
        }else{
            $data->status= 1;
        }
        $data->save();
        return response()->json(['success'=>"Successfully Changed"]);
    }
    public function designationcreate($id =' '){
        if($id>0){
            $edit = Designation::find($id);
            $department = Department::all();
            $designation = Designation::all();
            return view('admin.branch.designation',compact('department','designation','edit'));
        }else{
            $department = Department::all();
            $designation = Designation::all();
            return view('admin.branch.designation',compact('department','designation'));
        }
    }
    public function designationstore(Request $request){
        if($request->has('id')){
            $data= Designation::find($request->id);
        }else{
            $data= new Designation();
        }
        $data->designation_name=$request->designation;
        $data->department_id=$request->department_id;
        $data->status= ($request->status == '1')? 1 : 0;
        $data->save();
        return redirect()->route('admin.designation');
    }
    public function departmentdelete($id){
        $data = Designation::where('department_id',$id)->count();        
        if($data>0){           
            return response()->json([
                'msg' => 'no'
            ]); 
            }else{
                    $data = Department::find($id)->delete();
                    return response()->json([
                        'msg' => 'yes'
                    ]); 
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
