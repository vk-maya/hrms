<?php

namespace App\Http\Controllers\Admin;

use PDF;
use DateTime;
use Svg\Tag\Rect;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Setting;
use App\Models\Countries;
use App\Models\Attendance;
use App\Models\monthleave;
use App\Models\SalarySlip;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use App\Models\Admin\UserSlip;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\Admin\UserSalary;
use App\Http\Controllers\Controller;
use App\Models\Admin\CompanyProfile;
use App\Models\Admin\LeaveMonthAttandance;
use App\Models\Admin\SalaryManagment;
use Illuminate\Validation\Rules\Unique;
use App\Models\Admin\UserEarndeducation;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Admin\SalaryEarenDeduction;
use App\Models\Leave\Leave;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use CreateLeavesTable;

class PayrollController extends Controller
{
    public function salaryEarnDeducation($id)
    {
        $dataedit = SalaryEarenDeduction::with('salarymanag')->find($id);
        $data = SalaryManagment::where('status', 1)->get();
        $salarym = SalaryEarenDeduction::where('status', 1)->with('salarymanagement', 'session')->get();
        return view('admin.payroll.salary', compact('data', 'salarym', 'dataedit'));
        // dd($data->toarray());
    }
    //
    public function salaryinfo($id)
    {
        $salary = UserSalary::where('user_id', $id)->first();
        $user = User::find($id);
        // dd($salary);
        return response()->json(['salary' => $salary, 'user' => $user]);
    }
    //employees salary add & salary list show 
    public function payroll(Request $request)
    {
        $employees = User::where('status', 1)->with('salary')->get();
        return view('admin.payroll.payroll-list', compact('employees'));
    }
    //salary management module
    public function parolljs($id)
    {
        $salary = User::with(['userSalarySystem' => function ($query) {
            $session = Session::where('status', 1)->first();
            $query->where('salary_earen_deductions.session_id', $session->id);
        }, 'userSalaryData'])->find($id);
        return response()->json(compact('salary'));
    }

    //userslipmodules js
    public function viewSlip($id)
    {
        $company = CompanyProfile::where('status', 1)->first();
        $slip = UserSlip::with(['user.userDesignation'])->find($id);
        // dd($slip);
        return response()->json(compact('company', 'slip'));
        // return response()->json(['company' => $company, 'slip' => $slip]);
    }
    // -------year salary generate------------
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'net_salary' => 'required',
        ]);
        $userearndedu = UserEarndeducation::with('salaryEarningDeduction')->where('user_id', $request->employee_id)->get();
        if ($request->id > 0) {
            $payroll = UserSalary::find($request->id);
        } else {
            $payroll = new UserSalary();
        }
        $payroll->user_id = $request->employee_id;
        $payroll->net_salary = $request->net_salary;
        $user = User::first();
        $payroll->joiningDate = $user->joiningDate;
        $month = $request->net_salary / 12;
        $payroll->monthly = $month;
        $payroll->status = 1;
        $total_deduct = 0;
        $total_earn = 0;
        foreach ($userearndedu as $eardedu) {
            if ($eardedu->salaryEarningDeduction->salarymanagement->type == 'earning') {
                $deduct = $request->net_salary * $eardedu->salaryEarningDeduction->value / 100;
                $total_earn += (int)$deduct;
            } else {
                $deduct = $request->net_salary * $eardedu->salaryEarningDeduction->value / 100;
                $total_deduct += (int)$deduct;
            }
            $payroll[str_replace(' ', '_', strtolower($eardedu->salaryEarningDeduction->salarymanagement->title))] = $deduct;
        }
        $payroll->tDeducation = $total_deduct;
        $payroll->tEarning = $total_earn;
        $totaled = $total_deduct + $total_earn;
        $payroll->basic_salary = $request->net_salary - $totaled;
        $payroll->save();
        return redirect()->route('admin.payroll.list');
    }

    public function view_slip($id)
    {
        $id = $id;
        $employeeslip = UserSlip::where('user_id', $id)->with('user')->orderBy('id', 'DESC')->get();
        return view('admin.payroll.view-slip', compact('employeeslip', 'id'));
    }
    //salary blade redricet 
    public function genrateslip($id)
    {
        $id = $id;
        $employeesalary = SalarySlip::with('user')->find($id);
        //  dd($employeesalary->toarray());
        return view('admin.payroll.genrate-slip', compact('employeesalary', 'id'));
    }
    // public function downloadPdf($id){
    //     $employeesalary = SalarySlip::with('user')->find($id);
    //     view()->share('admin.payroll.slip-pdf', $employeesalary);
    //     $pdf = PDF::loadView('admin.payroll.slip-pdf', ['employeesalary' => $employeesalary]);
    //     // dd($employeesalary->toArray());
    //     return $pdf->download('slip.pdf');

    // --------------------salary management  list show-----------------
    public function salary_settings()
    {
        $data = SalaryManagment::where('status', 1)->get();
        $salarym = SalaryEarenDeduction::where('status', 1)->with('salarymanagement', 'session')->get();
        return view('admin.payroll.salary', compact('data', 'salarym'));
    }

    // ----------------salary management edit store--------------------
    public function salarymanagementedit(Request $request)
    {
        // dd("hh");
        $data = SalaryEarenDeduction::find($request->id);
        $data->value = $request->value;
        $data->save();
        return redirect()->route('admin.salary.settings');
    }

    //salary Generate function get blade
    public function empreport()
    {
        $users = User::with('usersalaryget')->where('status', 1)->select('id', 'first_name')->get();
        $month = Session::where('status', 1)->first();
        return view('admin.report.leavereport', compact('users', 'month'));
    }

    //monthly salary Generate
    public function salaryGenerate(Request $request){
        // dd($request->toArray());
        $salary = UserSalary::where('user_id', $request->user_id)->where('status', 1)->select('net_salary', 'id')->first();
        $userearndedu = UserEarndeducation::with('salaryEarningDeduction')->where('user_id', $request->user_id)->get();
        $salarymonth = Carbon::now()->startOfMonth($request->month)->subMonth(1);
        $salarymonth = date('Y-m', strtotime($salarymonth));
        $salarym = UserSlip::where('salary_month', $salarymonth)->where('user_id', $request->user_id)->count();
        $monthOfStartDate = Carbon::now()->startOfMonth()->toDateString();
        $monthOfEndDate = Carbon::now()->endOfMonth()->toDateString();

        // dd($salarySlipStatus,$monthOfEndDate);
        // $salarySlipStatus = UserSlip::where()
        if ($salarym < 1) {
            if ($request->id > 0) {
                $salarygenerate = UserSlip::find($request->id);
            } else {

                $salarygenerate = new UserSlip();
            }
            $salarygenerate->user_id = $request->user_id;
            $month = $salary->net_salary / 12;
            $salarygenerate->monthly_netsalary = $month;
            $salarygenerate->payslip_number = "SDCS-" . $request->user_id . rand(10, 10000);
            $salarygenerate->net_salary = $salary->net_salary;
            // dd($salarygenerate->net_salary);
            $salarygenerate->slip_month = $request->month;
            $salarygenerate->salary_month = $salarymonth;
            $salarygenerate->status = 1;
            $salarygenerate->user_salaryID = $salary->id;
            $total_deduct = 0;
            $total_earn = 0;
            foreach ($userearndedu as $eardedu) {
                if ($eardedu->salaryEarningDeduction->salarymanagement->type == 'earning') {
                    $deduct = $month * $eardedu->salaryEarningDeduction->value / 100;
                    $total_earn += (int)$deduct;
                } else {
                    $deduct = $month * $eardedu->salaryEarningDeduction->value / 100;
                    $total_deduct += (int)$deduct;
                }
                $salarygenerate[str_replace(' ', '_', strtolower($eardedu->salaryEarningDeduction->salarymanagement->title))] = $deduct;
            }
            $salarygenerate->tDeducation = $total_deduct;
            $salarygenerate->tEarning = $total_earn;
            $totaled = $month - $total_deduct;
            //month working day calculate salary
            $salarymonthLastDate = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
            $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            $dd = date('d', strtotime($salarymonthLastDate));
            $monthFingerApproved = LeaveMonthAttandance::where('user_id', $request->user_id)->where('date', $firstDayofPreviousMonth)->first();          
            $monthLeaveCalculate = monthleave::where('user_id', $request->user_id)->where('to', $salarymonthLastDate)->latest()->first();
            $daySalary = $month / $dd; //pr day salary calculate
            $dd = $dd - $monthLeaveCalculate->other; //net day working in month
            $paysalary = $dd * $daySalary; //paysalary calculate prday Vs Net working day
            $grossMonthSalary = $paysalary - $total_deduct;
            $salarygenerate->basic_salary = $totaled;
            $salarygenerate->leave_deduction = $monthLeaveCalculate->other * $daySalary;
            $salarygenerate->paysalary = $grossMonthSalary;
            // dd($salarygenerate->toArray());
            $salarygenerate->save();
        }
        return redirect()->route('admin.payroll.list');
    }


  
}
