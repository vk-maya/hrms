<?php

namespace App\Http\Controllers\Employees;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Projects;
use App\Models\userinfo;
use App\Models\Countries;
use App\Models\DailyTasks;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\Admin\Attach;
use App\Models\Attendance;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class UserController extends Controller
{
    public function profile()
    {
        return view('employees.profile.profile-password');
    }
    public function profileinfo()
    {
        $moreinfo = userinfo::where('user_id', Auth::guard('web')->user()->id)->count();
        $employees = User::with('moreinfo')->find(Auth::guard('web')->user()->id);
        return view('employees.profile.profile', compact('employees', 'moreinfo'));
    }
    public function profilemoreinfo()
    {
        $moreinfo = userinfo::where('user_id', Auth::guard('web')->user()->id)->count();
        if ($moreinfo > 0) {
            return redirect()->back();
        } else {
            return view('employees.profile.moreinfo');
        }
    }
    public function empmoreinfo(Request $request)
    {
        // dd($request->toArray());
        $rules = [
            'nationality' => ['required', 'string',],
            'maritalstatus' => ['required', 'string'],
            'children' => ['required', 'string',],
            'bankname' => ['required', 'string',],
            'bankAc' => ['required', 'integer',],
            'ifsc' => ['required', 'string',],
            'pan' => ['required', 'string',],
        ];
        $request->validate($rules);
        $data = new userinfo();
        $data->user_id = $request->user_id;
        $data->nationality = $request->nationality;
        $data->maritalStatus = $request->maritalstatus;
        $data->noOfChildren = $request->children;
        $data->bankname = $request->bankname;
        $data->bankAc = $request->bankAc;
        $data->ifsc = $request->ifsc;
        $data->pan = $request->pan;
        $data->status = 1;
        $data->save();
        return redirect()->route('employees.add.moreinfo');
    }
    public function proPassword(Request $request)
    {
        $rules = [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
        $request->validate($rules);
        $employees = User::find($request->id);
        $employees->password = Hash::make($request->password);
        $employees->update();
        return redirect()->route('dashboard');
    }
    public function empdashboard()
    {
        $data = DailyTasks::where('user_id', Auth::guard('web')->user()->id)->where('post_date', '>=', now()->toDateString())->count();
        $holi = Holiday::where('date', '>', now()->toDateString())->first();
        $attendance = Attendance::where('user_id', Auth::guard('web')->user()->machineID)->where('date', '>=', now()->toDateString())->latest()->first();
        $allatendance =  Attendance::where('user_id', Auth::guard('web')->user()->machineID)->get();
        // $nextday= User::all();
        // dd($nextday->toArray());
        return view('employees.dashboard', compact('data', 'holi', 'attendance', 'allatendance'));
    }
    public function fill()
    {
        $id = Auth::guard('web')->user()->id;
        $employees = User::find($id);
        $department = Department::get();
        $count = Countries::all();
        return view('employees.profile.fill-details', compact('department', 'employees', 'count'));
    }
    public function fillstore(Request $request)
    {

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'phone' => ['required', 'integer'],
            'address' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer'],
            'state_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'pincode' => ['required', 'integer', 'digits:6'],
        ];
        $request->validate($rules);
        $employees = User::find($request->id);
        $employees->verified = 1;
        $employees->first_name = $request->first_name;
        $employees->last_name = $request->last_name;
        $employees->gender = $request->gender;
        $employees->dob = date('Y-m-d', strtotime($request->dob));
        $employees->phone = $request->phone;
        $employees->address = $request->address;
        $employees->country_id = $request->country_id;
        $employees->state_id = $request->state_id;
        $employees->city_id = $request->city_id;
        $employees->pinCode = $request->pincode;
        if ($request->hasFile('image')) {
            storage::delete('public/uploads/' . $employees->image);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = "sdc" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $ext;
            $file = $request->file('image')->storeAs('public/uploads', $filename);
            $employees->image = $filename;
        }
        $employees->save();
        return redirect()->route('empdashboard');
    }

    public function country(Request $request)
    {
        $state = State::where('country_id', $request->contid)->get();
        return response()->json(['state' => $state]);
    }

    public function state(Request $request)
    {
        $data = City::where('state_id', $request->id)->get();
        return response()->json(['city' => $data]);
    }

    public function getdocument($id)
    {
        $files = Attach::where('user_id', $id)->get();
        return view('employees.Attach.attach-file', compact('files'));
    }

}
