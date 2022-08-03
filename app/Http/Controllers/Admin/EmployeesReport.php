<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\SalarySlip;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use App\Models\Admin\UserSlip;
use App\Models\EmployeeSalary;
use Illuminate\Support\Carbon;
use App\Models\Admin\UserSalary;
use App\Http\Controllers\Controller;
use App\Models\Admin\UserEarndeducation;
use Symfony\Component\VarDumper\Cloner\Data;

class EmployeesReport extends Controller
{
    public function empreport()
    {
        $users = User::with('usersalaryget')->where('status', 1)->select('id', 'first_name')->get();
        $month = Session::where('status', 1)->first();
        return view('admin.report.leavereport', compact('users', 'month'));
    }
    public function salaryGenerate(Request $request)
    {
        $salary = UserSalary::where('user_id', $request->user_id)->where('status', 1)->select('net_salary', 'id')->first();
        $userearndedu = UserEarndeducation::with('salaryEarningDeduction')->where('user_id', $request->user_id)->get();

        $salarymonth = Carbon::now()->startOfMonth($request->month)->subMonth(1);
        $salarymonth = date('Y-m', strtotime($salarymonth));
        $salarym = UserSlip::where('salary_month', $salarymonth)->where('user_id', $request->user_id)->count();
        if ($salarym < 1) {
            if ($request->id > 0) {
                $salarygenerate = UserSlip::find($request->id);
            } else {

                $salarygenerate = new UserSlip();

            }
            $salarygenerate->user_id = $request->user_id;
            $month = $salary->net_salary / 12;
            $salarygenerate->net_salary = $salary->net_salary;
            $salarygenerate->slip_month = $request->month;
            $salarygenerate->salary_month = $salarymonth;
            $salarygenerate->status = 1;
            $salarygenerate->user_salaryID = $salary->id;
            $total_deduct = 0;
            $total_earn = 0;
            foreach ($userearndedu as $eardedu) {
                // dd($eardedu);
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
            $salarygenerate->basic_salary = $totaled;
            $salarygenerate->save();
        }
        return redirect()->route('admin.payroll.list');
    }
}
