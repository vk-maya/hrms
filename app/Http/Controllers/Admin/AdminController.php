<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SalaryEarenDeduction;
use App\Models\Admin\Session;
use App\Models\Admin\UserEarndeducation;
use App\Models\Admin\UserleaveYear;
use App\Models\Countries;
use App\Models\Department;
use App\Models\Leave\settingleave;
use App\Models\monthleave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function leaveSetting()
    {
        $data = settingleave::get();
        return view('admin.leave.setting', compact('data'));
    }

    public function addLeaveType($id = null)
    {
        $leave = null;
        if ($id != NULL) {
            $leave = settingleave::find($id);
        }

        return view('admin.leave.add_leave_type', compact('leave'));
    }

    public function storeLeaveType(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'day' => 'required',
        ]);
        if ($request->has('id')) {
            $leave = settingleave::find($request->id);
        } else {
            $leave = new settingleave();
        }

        $leave->type = $request->type;
        $leave->day = $request->day;
        $leave->carryfordward = $request->carryfordward;
        $leave->status = 1;
        $leave->save();

        return redirect()->route('admin.leave-setting');
    }

    public function addEmployee($id = null)
    {
        $employee = null;
        $user_salary = null;
        $empid = null;
        $session = Session::where('status', 1)->first();
        $salared = SalaryEarenDeduction::with('salarymanag')->where('session_id', $session->id)->where('status', 1)->get();
        $department = Department::get();
        $country = Countries::all();

        if ($id != NULL){
            $user_salary = UserEarndeducation::where('User_id', $id)->pluck('salary_earndeductionID');
            $employee = User::find($id);
        }else{
            $latest = User::latest()->first();
            if (!empty($latest)){
                $emp = explode('-', $latest->employeeID);
                $empid = '00'.(1 + $emp[2]);
            }else{
                $empid = "0001";
            }
        }
        return view('admin.employees.add_employee', compact('employee', 'session', 'salared', 'department', 'country', 'user_salary', 'empid'));
    }

    public function storeEmployee(Request $request)
    {
        $company_start_date = Carbon::parse('2019-01-01');
        $dobmax = Carbon::now()->subMonths(216)->toDateString();
        if ($request->has('id')){
            $rules = [
                'first_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                'joiningDate' => ['date', 'required', 'after:'.$company_start_date],
                'department_id' => ['required', 'numeric', 'exists:departments,id'],
                'designation_id' => ['required', 'numeric', 'exists:designations,id']
            ];
            $request->validate($rules);
            $employee = User::find($request->id);
            $leaveyearr = UserleaveYear::where('user_id', $request->id)->where('status', 1)->first();
        }else{
            $rules = [
                'first_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'joiningDate' => ['date', 'required', 'after:'.$company_start_date],
                'department_id' => ['required', 'numeric', 'exists:departments,id'],
                'designation_id' => ['required', 'numeric', 'exists:designations,id']
            ];
            $request->validate($rules);
            $employee = new User();
        }
        if ($request->dob != null) {
            $rules['dob'] = ['required', 'date', 'before:'.$dobmax];
            $request->validate($rules);
        }

        if ($request->pincode != null) {
            $rules['pincode'] = ['required', 'integer', 'digits:6'];
            $request->validate($rules);
        }

        $latest = User::latest()->select('employeeID')->first();
        if (!$request->has('id')){
            if (!empty($latest)) {
                $emp = explode('-', $latest->employeeID);
                $empid = 1 + $emp[2];
                if ($empid < 9){
                    $empid = 'SDPL-JAI-000' . $empid;
                }elseif ($empid < 99){
                    $empid = 'SDPL-JAI-00' . $empid;
                }elseif ($empid < 100){
                    $empid = 'SDPL-JAI-0' . $empid;
                }else{
                    $empid = 'SDPL-JAI-' . $empid;
                }
            }else{
                $empid = "SDPL-JAI-0001";
            }
            $employee->employeeID = $empid;
        }
        if (!empty($request->password))
        {
            $employee->password = Hash::make($request->password);
        }

        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->gender = $request->gender;
        $employee->machineID = $request->machineID;
        $employee->phone = $request->phone;
        $employee->department_id = $request->department_id;
        $employee->designation_id = $request->designation_id;
        $employee->address = $request->address;
        $employee->country_id = $request->country_id;
        $employee->state_id = $request->state_id;
        $employee->city_id = $request->city_id;
        $employee->pinCode = $request->pincode;
        $employee->status = ($request->status == 1) ? 1 : 0;
        $employee->workplace = $request->workplace;
        if ($request->hasFile('image'))
        {
            Storage::delete('public/uploads/' . $employee->image);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = "sdc" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $ext;
            $file = $request->file('image')
                ->storeAs('public/uploads', $filename);
            $employee->image = $filename;
        }

        // if ($employee->save()) {
        if (true) {
            $session = Session::where('status', 1)->latest()->first();
            if (!$request->has('id')){
                $user_yearleave = new UserleaveYear();
                // $user_yearleave->user_id = $employee->id;
                $user_yearleave->user_id = 1;
                $user_yearleave->session_id = $session->id;

                $allleave = settingleave::where('status', 1)->get();
                $jd = $request->joiningDate;
                if ($jd <= $session->from){
                    $jd = $session->from;
                }

                $diffr = round(Carbon::parse($jd)->floatDiffInMonths($session->to));

                foreach ($allleave as $value){
                    if ($value->type == 'PL'){
                        $day = $diffr *= $value->day / 12;
                        $user_yearleave->basicAnual = $day;
                    }elseif ($value->type == 'Sick'){
                        $day = $diffr *= $value->day / 12;
                        $user_yearleave->basicSick = $day;
                    }elseif ($value->type == 'other'){
                        $day = $diffr = $value->day;
                        $user_yearleave->other = $day;
                    }
                }
                $user_yearleave->status = 1;
                // if ($user_yearleave->save()) {
                if (true) {
                    foreach ($allleave as $key => $value){
                        if ($value->type == "PL"){
                            $anual = $value->day / 12;
                        }elseif ($value->type == "Sick"){
                            $sickl = $value->day / 12;
                        }
                    }

                    $data = new monthleave();
                    // $data->user_id = $employee->id;
                    // $data->useryear_id = $user_yearleave->id;
                    $data->user_id = 1;
                    $data->useryear_id = 1;
                    // $jd = '2022-05-24';

                    $diffr = round(Carbon::parse($jd)->floatDiffInMonths(Carbon::now()));
                    // dd($diffr);

                    // dd(Carbon::now()->daysInMonth);
                    dd(Carbon::now()->subMonth($diffr));

                    $str = date('Y-m', strtotime($jd));
                    $strr = $str . "-15";

                    if ($jd >= $session->from)
                    {
                        if ($jd < $strr)
                        {
                            $jd = date('Y-m', strtotime($jd));
                            $jd = $jd . "-01";
                        }
                        else
                        {
                            $jd = Carbon::parse($jd)->addMonths();
                            $jd = date('Y-m', strtotime($jd));
                            $jd = $jd . "-01";
                        }
                    }else{
                        $jd = $session->from;
                    }
                    $end = now();
                    $end = date('Y-m', strtotime($end));
                    $end = Carbon::parse($end)->endOfMonth(); //Last Date of Month
                    $end = date('Y-m-d', strtotime($end));
                    $diffr = round(Carbon::parse($jd)->floatDiffInMonths($end));
                    $from = date('Y-m-d', strtotime($jd));
                    $to = date('Y-m-d', strtotime($end));
                    $data->from = $from;
                    $data->to = $to;
                    $anual = $diffr * $anual;
                    $sick = $diffr * $sickl;
                    $data->anualLeave = $anual;
                    $data->sickLeave = $sick;
                    $data->status = 1;
                    $data->save();
                }
            }
        }

        dd($employee->toArray());
        $employee->userSalaryData()->sync($request->earning);
    }
}
