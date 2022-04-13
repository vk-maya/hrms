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
        $rr= User::where('email', 'like',"%$request->x%")->count();
        return json_encode(['count'=>$rr]);
    }
    public function epid(Request $request)
    {
        $rr= User::where('employee_id', 'like',"%$request->x%")->count();
        return json_encode(['count'=>$rr]);
    }
    public function employeecreate(){
          
        return view('admin.employees.employees');
    }
    public function addemployeescreate(){
        $designation = Designation::all();
        $department = Department::all(); 
        return view('admin.employees.employees-add', compact('designation','department'));
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
            $filename =$request->name.rand(0,10000).".".$ext;
            $file = $request->file('image')->storeAs('public/uploads',$filename);
            $data->image =$filename;
        }
        $data->save();
        return redirect('/admin/dashboard');
    }
}
