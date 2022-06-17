<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeSalary;
use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Countries;
use App\Models\State;
use App\Models\City;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

class PayrollController extends Controller
{
    //
    public function payroll(Request $request)
    {
        $employee = User::get();
        $increment = Setting::get();
        if ($request->id > 0) {
            $edit = EmployeeSalary::find($request->id);
            return response()->json(['edit' => $edit]);
        } else {
            $employeesalary = EmployeeSalary::with('user')->get()->unique('employee_id');
        }
        return view('admin.payroll.payroll-list', compact('employee', 'employeesalary','increment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'net_salary' => 'required',
            'basic_salary' => 'required'
        ]);
        if ($request->id > 0) {
            # code...
            $payroll = EmployeeSalary::find($request->id);
        } else {
            $payroll = new EmployeeSalary();
        }
        $payroll->employee_id = $request->employee_id;
        $payroll->net_salary = $request->net_salary;
        $payroll->basic_salary = $request->basic_salary;
        $payroll->tds = $request->tds;
        $payroll->da = $request->da;
        $payroll->est = $request->est;
        $payroll->hra = $request->hra;
        $payroll->pf = $request->pf;
        $payroll->conveyance = $request->conveyance;
        $payroll->Prof_tax = $request->Prof_tax;
        $payroll->allowance = $request->allowance;
        $payroll->Labour_welf = $request->Labour_welf;
        $payroll->Medical_allow = $request->Medical_allow;
        $payroll->other = $request->other;
        // dd($payroll->toArray());
        $payroll->save();
        return redirect()->route('admin.payroll.list');
    }
    //..............view-employee-slip............................/
    public function view_slip($employee_id)
    {
        $employee = User::get();
        $employeeslip = EmployeeSalary::with('user')->where('employee_id', $employee_id)->get();
        return view('admin.payroll.view-slip', compact('employeeslip', 'employee'));
    }

    public function genrateslip($id)
    {
        $employeesalary = EmployeeSalary::with('user')->find($id);

        //  dd($employeesalary->toarray());
        return view('admin.payroll.genrate-slip', compact('employeesalary'));
    }
    ///........................settings......................////
    public function settings()
    {
        $setting = Setting::get();
        $data = Countries::all();
        return view('admin.payroll.setting', compact('data', 'setting'));
    }


    public function setting_store(Request $request)
    {

        unset($request['_token']);
        foreach ($request->all() as $key => $value) {
            $setting = (Setting::where('title', $key)->count() > 0) ? Setting::where('title', $key)->first() : new Setting();
            $setting->title = $key;
            $setting->description = ($value == null) ? "" : $value;
            $setting->status = 1;
            $setting->save();
        }
        return redirect()->back();
    }

    public function salary_settings()
    {
        $salary = Setting::get();
        return view('admin.payroll.salary' ,compact('salary'));
    }
    public function salary_store(Request $request)
    {
        // dd($request->toArray());
        unset($request['_token']);
        $id = 0;
        $i = 1;
        foreach ($request->all() as $key =>  $value) {
            if($key == 'flexRadioDefault'.$i){
                $i++;
                $up = Setting::find($id);
                $up->type = $value;
                $up->save();
                continue;
            }
            $salary = (Setting::where('title', $key)->count() > 0) ? Setting::where('title', $key)->first() : new Setting();
            $salary->title = $key;
            $salary->description = $value;
            $salary->status = 1;
            $salary->save();
            $id = $salary->id;
        }
        return redirect()->back();
    }

}
