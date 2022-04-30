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
use Illuminate\Auth\Events\Validated;
use App\Models\Countrie;
use App\Models\State;
use App\Models\City;

class EmployeesController extends Controller
{
    // -----------------------email check get------------
    public function emailv(Request $request) {
        $rrr = User::withTrashed()->where('email', 'like', "%$request->x%")->count();
        return json_encode(['count' => $rrr]);
    }

// -----------------employees id get----------------------
    public function epid(Request $request) {
        $idd = User::where('employee_id', 'like', "%$request->y%")->count();
        return json_encode(['count' => $idd]);
    }

// ------------------------designation get------------------
    public function designationfatch(Request $request){
        $designation = Designation::where('department_id', $request->dep)->get();
        return json_encode(['count' => $designation]);
    }

// ------------------------------state and city ajax------
    public function country(Request $request){
        $state = State::where('country_id', $request->contid)->get();
        return response()->json(['state' => $state]);
    }

    public function state(Request $request){
        $data = City::where('state_id', $request->id)->get();
        return response()->json(['city' => $data]);
    }

// --------------------delete ajax-----------------------
    public function employeesdestroy($id) {
        $delete = User::find($id);
        if ($delete->image != '') {
            storage::delete('public/uploads/' . $delete->image);
        }
        $delete->delete();
        return response()->json(['msg' => 'yes']);
    }

    // --------------------laravel request function---------
    public function employeecreate(){

        $department = Designation::with('department')->get();
        $employees = User::all();

        return view('admin.employees.employees', compact('employees', 'department',));
    }
    
    // ------------------employees list---------------------
    public function emplist(){
        $ldepartment = Designation::with('department')->get();
        $lemployees = User::all();

        return view('admin.employees.employees', compact('lemployees', 'ldepartment',));
    }

    public function addemployeescreate(Request $request){
        if ($request->id != '') {
            $employees = User::find($request->id);
            $department = Department::get();
            $count = Countrie::all();

            return view('admin.employees.employees-add', compact('department', 'employees', 'count'));
        } else {
            $department = Department::get();
            $count = Countrie::all();
            $id = User::latest()->first();
            if($id==!null){
                $empid=1+$id->employee_id;
            }else{

                $empid=1000;
            }

          
            return view('admin.employees.employees-add', compact('department', 'count','empid'));
        }
    }

    public function addemployeesstore(Request $request){   
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'employee_id' => ['required', 'string', 'numeric'],
            'designation' => ['required', 'string', 'numeric','max:255'],          
            'joining_date' => ['string','required'],          
            'phone' => ['required', 'string', 'max:12'],          
            'country' => ['required','string',],          
            'state' => ['required', 'string',],
            'city' => ['required', 'string'],
            'department' => ['required', 'string',],
            'designation' => ['required', 'string','numeric'],
            'image' => [ 'required','mimes:png,jpg,jpeg,csv','max:2048'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(8),Rules\Password::defaults()],
        ];
        if ($request->id == !null) {
            $employees = User::find($request->id);
            storage::delete('public/uploads/' . $employees->image);
            // $img = $employees->image;
            // if (Storage::disk('public')->exists('uploads/' . $img)) {
            //     unlink('storage/uploads/' . $img);
            // }
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
            if(User::where('email',$request->email)->where('id','!',$request->id)->count() > 0){
                return response()->back()->withErrors(['email'=>"Email Already Exist"])->withInput();
            }
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $employees = new User();
        }
        $request->validate($rules);
        $employees->name = $request->name;
        $employees->last_name = $request->last_name;
        $employees->email = $request->email;
        $employees->password =$request->password;
        $employees->employee_id = $request->employee_id;
        $employees->joining_date = date('Y-m-d', strtotime($request->joining_date));
        $employees->phone = $request->phone;
        $employees->department_id = $request->department;
        $employees->designation_id = $request->designation;
        $employees->address = $request->address;
        $employees->country_id = $request->country;
        $employees->state_id = $request->state;
        $employees->city_id = $request->city;
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
}
