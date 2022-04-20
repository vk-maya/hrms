<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;


class EmployeesController extends Controller
{
    public function emailv(Request $request)
    {
        $rrr = User::where('email', 'like', "%$request->x%")->count();
        return json_encode(['count' => $rrr]);
    }
    public function epid(Request $request)
    {
        $idd = User::where('employee_id', 'like', "%$request->y%")->count();
        return json_encode(['count' => $idd]);
    }
    public function designationfatch(Request $request)
    {
        $designation = Designation::where('department_id', $request->dep)->get();
        return json_encode(['count' => $designation]);
    }
    public function employeecreate()
    {
        $department = Designation::with('department')->get();
        $employees = User::all();
        return view('admin.employees.employees', compact('employees', 'department'));
    }
    public function addemployeescreate(Request $request)
    {
        if ($request->id != '') {
            $employees = User::find($request->id);
            $department = Department::get();
            return view('admin.employees.employees-add', compact('department', 'employees'));
        } else {
            $department = Department::get();
            return view('admin.employees.employees-add', compact('department'));
        }
    }
    public function addemployeesstore(Request $request)
    {       
        $request->validate([
            'name' => ['required', 'string', 'max:255'],            
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        if ($request->id == !null) {
            $employees = User::find($request->id);
            $img = $employees->image;
            if (Storage::disk('public')->exists('uploads/' . $img)) {
                unlink('storage/uploads/' . $img);
            }
        } else {
            $employees = new User();
        }       
        $employees->name = $request->name;
        $employees->last_name = $request->last_name;
        $employees->email = $request->email;
        $employees->password = Hash::make($request->password);
        $employees->employee_id = $request->employee_id;
        $employees->joining_date = date('Y-m-d', strtotime($request->joining_date));
        $employees->phone = $request->phone;
        $employees->department_id = $request->department_id;
        $employees->designation_id = $request->designation_id;
        $employees->address = $request->address;
        $employees->state = $request->state;
        $employees->city = $request->city;
        $employees->status = ($request->status == 1) ? 1 : 0;
        $employees->workplace = $request->workplace;
      
        $employees->image = '';
        if ($request->hasFile('image') == 1) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = "sdc" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $ext;
            $file = $request->file('image')->storeAs('public/uploads', $filename);
            $employees->image = $filename;
        }
        $employees->save();
        return redirect()->route('admin.employees');
    }
    public function employeesdestroy($id)
    {
        $delete = User::find($id);
        if ($delete->image != '') {
            storage::delete('public/uploads/' . $delete->image);
        }
        $delete->delete();
        return response()->json(['msg'=>'yes']);
    }
}
