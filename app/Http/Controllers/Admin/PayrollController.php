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
use App\Models\SalarySlip;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Carbon;
use PDF;

class PayrollController extends Controller
{
    //
    public function payroll(Request $request)
    {

        $ids = EmployeeSalary::get()->unique('employee_id')->pluck('employee_id');
        $employee = User::whereNotIn('id', $ids)->get();
        $employeeincre = User::get();
        $increment = Setting::get();
        if ($request->id > 0) {
            $edit = EmployeeSalary::find($request->id);
            return response()->json(['edit' => $edit]);
        } else {
            $employeesalary = EmployeeSalary::with('user')->get()->unique('employee_id');
        }
        return view('admin.payroll.payroll-list', compact('employee', 'employeeincre', 'employeesalary', 'increment'));
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
        $joindate = User::first();
        $payroll->date = $joindate->joiningDate;
        $payroll->monthly = $request->net_salary / 12;
        $payroll->status = 1;
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
        $payroll->save();
        return redirect()->route('admin.payroll.list');
    }
    //...........................employee_increment.....................///
    public function increment(Request $request)
    {

        EmployeeSalary::where('employee_id', $request->id)->update(['status' => 0]);
        $increment = new EmployeeSalary();
        $increment->employee_id = $request->id;
        $increment->net_salary = $request->net_salary_new;
        $increment->date = date('Y-m-d');
        $increment->monthly = $request->monthly_new;
        $increment->status = 1;
        $increment->increment = $request->increment;
        $increment->basic_salary = $request->basic_salary;
        $increment->tds = $request->tds;
        $increment->da = $request->da;
        $increment->est = $request->est;
        $increment->hra = $request->hra;
        $increment->pf = $request->pf;
        $increment->conveyance = $request->conveyance;
        $increment->Prof_tax = $request->Prof_tax;
        $increment->allowance = $request->allowance;
        $increment->Labour_welf = $request->Labour_welf;
        $increment->Medical_allow = $request->Medical_allow;
        $increment->other = $request->other;
        // dd($increment->toArray());
        $increment->save();
        return redirect()->back();
    }
    //..............view-employee-slip............................/
    public function slip(Request $request, $id)
    {
        $check = SalarySlip::where('employee_id', $request->employee_id)->whereBetween('date',[now()->startOfMonth()->toDateString(),now()->endOfMonth()->toDateString()])->count();
        if ($check > 0){
            return redirect()->back()->with('error','Employee Salary Slip already Generate');
        }
        $employeeslip = EmployeeSalary::where('employee_id', $id)->where('status', 1)->first();
        $generate = new SalarySlip();
        $generate->employee_id = $employeeslip->employee_id;
        $generate->basic_salary = $employeeslip->basic_salary;
        $generate->monthly = $employeeslip->monthly;
        $generate->date = date('y-m-d');
        $generate->status = 1;
        $generate->tds = $employeeslip->tds;
        $generate->da = $employeeslip->da;
        $generate->est = $employeeslip->est;
        $generate->hra = $employeeslip->hra;
        $generate->pf = $employeeslip->pf;
        $generate->conveyance = $employeeslip->conveyance;
        $generate->Prof_tax = $employeeslip->Prof_tax;
        $generate->allowance = $employeeslip->allowance;
        $generate->Labour_welf = $employeeslip->Labour_welf;
        $generate->Medical_allow = $employeeslip->Medical_allow;
        $generate->other = $employeeslip->other;
        //    dd($generate->toArray());
        $generate->save();
        return redirect()->back()->with('success', 'Employee Salary Slip Generated Success !');
    }
    public function view_slip($employee_id)
    {

        $slipgenerate = EmployeeSalary::where('employee_id', $employee_id)->get();
        $employee = User::get();
        $employeeslip = SalarySlip::with('user')->where('employee_id', $employee_id)->get();
        return view('admin.payroll.view-slip', compact('employeeslip', 'employee', 'slipgenerate'));
    }

    public function genrateslip($id)
    {
        $employeesalary = SalarySlip::with('user')->find($id);
        //  dd($employeesalary->toarray());
        return view('admin.payroll.genrate-slip', compact('employeesalary'));
    }

    public function downloadPdf($id)
    {
        $employeesalary = SalarySlip::with('user')->find($id);
        view()->share('admin.payroll.slip-pdf',$employeesalary);
        $pdf = PDF::loadView('admin.payroll.slip-pdf', ['employeesalary' => $employeesalary]);
        // dd($employeesalary->toArray());
        return $pdf->download('slip.pdf');
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
        return view('admin.payroll.salary', compact('salary'));
    }
    public function salary_store(Request $request)
    {
        // dd($request->toArray());
        unset($request['_token']);
        $id = 0;
        $i = 1;
        foreach ($request->all() as $key =>  $value) {
            if ($key == 'flexRadioDefault' . $i) {
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
