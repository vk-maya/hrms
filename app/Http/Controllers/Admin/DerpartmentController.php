<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DerpartmentController extends Controller
{
    public function departmentscreate(Request $request){
        if ($request->id > 0) {
            $edit = Department::find($request->id);
            return response()->json(['edit' => $edit]);
        } else {
            $department = Department::all();
            return view('admin.branch.departments', compact('department'));
        }
    }
    public function departmentsstore(Request $request){
        $rules = [
            'department' => ['required', 'string', 'max:255'],

        ];
        if ($request->has('id')) {
            $data = Department::find($request->id);
        } else {
            $data = new Department();
        }
        $request->validate($rules);
      
        $data->department_name = $request->department;
        $data->status = ($request->status == '1') ? 1 : 0;
        $data->save();
        
        return back()->with('success', 'User created successfully.');
    }
    public function departmentsstatus(Request $request){
        $data = Department::find($request->id);
        if ($data->status == 1) {
            $data->status = 0;
        } else {
            $data->status = 1;
        }
        $data->save();
        return response()->json(['success' => "Successfully Changed"]);
    }
    public function designationstatus(Request $request) {
        // dd($request->toArray());
        $data = Designation::find($request->id);
        if ($data->status == 1) {
            $data->status = 0;
        } else {
            $data->status = 1;
        }
        $data->save();
        return response()->json(['msg' => "yes"]);
    }
    public function designationcreate($id = ''){

        if ($id > 0) {
            // dd($id);
            $edit = Designation::find($id);

            return response()->json(['msg' => $edit]);
        } else {
            $department = Department::all();
            $designation = Designation::all();
            return view('admin.branch.designation', compact('department', 'designation'));
        }
    }
    public function designationstore(Request $request){
        $rules = [
            'designation' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'string', 'max:255'],

        ];
        if ($request->has('id')) {
            $data = Designation::find($request->id);
        } else {
            $data = new Designation();
        }
        $request->validate($rules);
        $data->designation_name = $request->designation;
        $data->department_id = $request->department_id;
        $data->status = ($request->status == '1') ? 1 : 0;
        $data->save();
        return redirect()->route('admin.designation');
    }
    public function departmentdelete($id) {
        $data = Designation::where('department_id', $id)->count();
        if ($data > 0) {
            return response()->json([
                'msg' => 'no'
            ]);
        } else {
            $data = Department::find($id)->delete();
            return response()->json([
                'msg' => 'yes'
            ]);
        }
    }
    public function designationdelete($id){
        $data = User::where('designation_id', $id)->count();
        if ($data > 0) {
            return response()->json(['msg' => 'no']);
        } else {
            $data = Designation::find($id)->delete();
            return response()->json(['msg' => 'yes']);
        }
    }
}
