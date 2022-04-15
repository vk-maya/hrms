<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules;


class EmployeesController extends Controller
{
    public function emailv(Request $request)
    {
        $rrr = User::where('email', 'like',"%$request->x%")->count();
        return json_encode(['count'=>$rrr]);
    }
    public function epid(Request $request)
    {
        $idd= User::where('employee_id', 'like',"%$request->y%")->count();
        return json_encode(['count'=>$idd]);
    }
    public function designationfatch(Request $request){
        $designation = Designation::where('department_id',$request->dep)->get();
        return json_encode(['count'=>$designation]);
    }
    public function employeecreate(){
        $department = Designation::with('department')->get();
        $employees= User::all();          
        return view('admin.employees.employees',compact('employees','department'));
    }
    public function addemployeescreate(){
        $department = Department::get();
        return view('admin.employees.employees-add', compact('department'));
    }
    public function addemployeesstore(Request $request){       
        $data= new User();
        $data->name=$request->name;        
        $data->last_name=$request->last_name;        
        $data->email =$request->email;        
        $data->password =Hash::make($request->password);       
        $data->employee_id =$request->employee_id;        
        $data->joining_date =date('Y-m-d',strtotime($request->joining_date));        
        $data->phone =$request->phone;        
        $data->department_id =$request->department_id;        
        $data->designation_id =$request->designation_id;        
        $data->address =$request->address;        
        $data->city =$request->city;        
        $data->state =$request->state;        
        $data->status =$request->status;        
        $data->workplace =$request->workplace;   
        // dd($data->toArray());
        $data->image="";
        if ($request->hasFile('image') == 1) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename ="sdc".str_replace(' ', '',$request->name).rand(0,10000).".".$ext;
            $file = $request->file('image')->storeAs('public/uploads',$filename);
            $data->image =$filename;
        }
        $data->save();
        return redirect('/admin/employees');
    }
}
