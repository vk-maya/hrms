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
use App\Models\Admin\MonthDayLeave;
use App\Models\Admin\MonthSaturdayLeave;
use App\Models\Admin\SalaryManagment;
use Illuminate\Validation\Rules\Unique;
use App\Models\Admin\UserEarndeducation;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Admin\SalaryEarenDeduction;
use App\Models\Holiday;
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
        return response()->json(['salary' => $salary, 'user' => $user]);
    }
    //employees salary add & salary list show
    public function payroll(Request $request)
    {
        $employees = User::where('status', 1)->with('salary')->orderBy('first_name')->get();
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
        return response()->json(compact('company', 'slip'));
    }
    //Earning And Deduction  Value Save in fnction
    public function salary_store(Request $request)
    {
        foreach ($request->ids as $key => $title) {
            $sess = Session::where('status', 1)->first();
            $data = new SalaryEarenDeduction();
            $data->salaryM_id = $key;
            $data->session_id = $sess->id;
            $data->value = $title;
            $data->status = 1;
            $data->save();
        }
        // dd($data->toArray());
        return redirect()->back();
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
        $salary = UserSalary::where('user_id', $request->user_id)->where('status', 1)->first();
        $userearndedu = UserEarndeducation::with('salaryEarningDeduction')->where('user_id', $request->user_id)->get(); 
        $monthLeaveCalculate = monthleave::where('user_id', $request->user_id)->where('status',0)->get();
        foreach ($monthLeaveCalculate as $key => $monthLeaveCal) {
        if ($monthLeaveCal!= null && $salary!= null) {
        $dateFrom = new DateTime($monthLeaveCal->from);
            $dateTo = new DateTime($monthLeaveCal->to);
            $interval = $dateFrom->diff($dateTo);
            $da = $interval->format('%a');
            $days = $da + 1;
            $salarymonthDay = $days;//month day as joning date and accepect date
            if ($request->id > 0) {
                $salarygenerate = UserSlip::find($request->id);
            } else {
                    $salarygenerate = new UserSlip();
            }
                    $salarygenerate->user_id = $request->user_id;
                    $month = $salary->monthly;
                    $inMonthDay = date('d', strtotime($monthLeaveCal->to));
                    $NetDay = $salarymonthDay; //total working day in month
                    $daySalary = $month / $inMonthDay; //pr day salary calculate
                if (isset($monthLeaveCal->other) && $monthLeaveCal->other != null) {
                    $salarymonthDay = $salarymonthDay - $monthLeaveCal->other; //net day working in month
                }
                    $paysalary = $salarymonthDay * $daySalary; //paysalary calculate prday Vs Net working day && pay salary decuction of leave
                    $monthLeaveCal->status = 3;
                    $monthLeaveCal->save();
                    $month = round($paysalary);
                    $salarygenerate->monthly_netsalary = $month; // net monthly salary
                    $salarygenerate->payslip_number = "SDCS-" . $request->user_id . rand(10, 10000);
                    $salarygenerate->net_salary = $salary->net_salary;
                    $salarygenerate->slip_month = $request->month;
                    $salarygenerate->salary_month =  date('Y-m', strtotime($monthLeaveCal->to));
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
                    $salarygenerate[str_replace(' ', '_', strtolower($eardedu->salaryEarningDeduction->salarymanagement->title))] = round($deduct);
                }
                        $salarygenerate->tDeducation = $total_deduct;
                        $salarygenerate->tEarning = $total_earn;
                        $totaled = $month - $total_deduct;
                        $grossMonthSalary = $paysalary - $total_deduct;
                if (isset($monthLeaveCal->other) && $monthLeaveCal->other != null) {
                    $salarygenerate->leave_deduction = round($monthLeaveCal->other * $daySalary);
                } else {
                    $salarygenerate->leave_deduction = 0 * $daySalary;
                }
                        $salarygenerate->paysalary = round($grossMonthSalary);
                        $salarygenerate->basic_salary = $totaled + $salarygenerate->leave_deduction;
                        $salarygenerate->save();
                    }
                }
        return redirect()->route('admin.payroll.list');
    }
    public function testroute($id)
    {
        // dd("hello");
        $user = User::where(['status'=> 1,'id'=>$id])->first();
        // $user=$id;
        // foreach ($user_data as $user) {
            $today = \Carbon\Carbon::now();
            $fristMonthofDay = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
            $lastMonthofDay = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
            $leaves = Leaverecord::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
                $query->whereBetween('from', [$fristMonthofDay, $lastMonthofDay]);
            })->get();
            $leavesGet = Leaverecord::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
                $query->whereBetween('from', [$fristMonthofDay, $lastMonthofDay]);
            })->count();
            $leavet = settingleave::where('status', 1)->get();
/*
            // // -------------------------------total Leave count----------------------------------

            // if ($leavesGet > 0) {
            //     foreach ($leaves as $leave) {
            //         $leavetype = settingleave::find($leave->type_id);
            //         $monthleave = monthleave::where('user_id', $leave->user_id)->where('status', 1)->where('to', $lastMonthofDay)->first();
            //         if ($leavetype->type == "PL") {
            //             if ($monthleave != null) {
            //                 $monthleave->apprAnual = $monthleave->apprAnual + $leave->day;
            //             } else {
            //                 $monthleave->apprAnual = $leave->day;
            //             }
            //         } elseif ($leavetype->type == "Sick") {
            //             if ($monthleave != null) {
            //                 $monthleave->apprSick = $monthleave->apprSick + $leave->day;
            //             } else {
            //                 $monthleave->apprSick = $leave->day;
            //             }
            //         } else {
            //             if ($monthleave != null) {
            //                 $monthleave->other = $monthleave->other + $leave->day;
            //             } else {
            //                 $monthleave->other = $leave->day;
            //             }
            //         }
            //         $monthleave->status = 1;
            //         $monthleave->save();
            //     }
            // } else {
            //     $monthleave = monthleave::where('user_id', $user->id)->where('status', 1)->first();
            //     $monthleave->status = 0;
            //     $monthleave->save();
            // }

            // --------------------------------------------------Attendance function --------------  //Attendance Vs Month Leave Table----

            // $salarymonthLastDate = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
            // $firstDayofPreviousMonth = Carbon::now()->startOfMonth()->subMonth()->toDateString();
            // $dd = date('d', strtotime($salarymonthLastDate));
            // $monthFingerApproved = LeaveMonthAttandance::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
            //     $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);
            // })->count();
            // if ($monthFingerApproved > 0) {
            //     $monthFingerApproved = LeaveMonthAttandance::where('user_id', $user->id)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
            //         $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);
            //     })->get();

            //     foreach ($monthFingerApproved as $key => $aLeave) {
            //         $monthleave = monthleave::where('user_id', $leave->user_id)->where('status', 1)->where('to', $lastMonthofDay)->first();
            //         $leavetype = settingleave::find($aLeave->type_id);
            //         if ($leavetype->type == "PL") {
            //             if ($monthleave->apprAnual > 0) {
            //                 $monthleave->apprAnual = $monthleave->apprAnual - $aLeave->anual;
            //             }
            //         } elseif ($leavetype->type == "Sick") {
            //             if ($monthleave->apprSick > 0) {
            //                 $monthleave->apprSick = $monthleave->apprSick - $aLeave->sick;
            //             }
            //         } else {
            //             if ($monthleave->other > 0) {
            //                 $monthleave->other = $monthleave->other - $aLeave->other;
            //             }
            //         }
            //         $monthleave->save();
            //     }
            // }
*/
            /*
            // --------------------------------------------Attendance without leave absent function--------------
                    $monthFingerAbsunt = Attendance::where('user_id', $user->id)->where('status', 0)->where(function ($query) use ($fristMonthofDay, $lastMonthofDay) {
                        $query->whereBetween('date', [$fristMonthofDay, $lastMonthofDay]);})->count();
                        if ($monthFingerAbsunt > 0) {
                            $monthleave = monthleave::where('user_id', $user->id)->where('status', 1)->where('to', $lastMonthofDay)->first();
                            // dd($monthleave);
                            $totalLeave = $monthleave->apprAnual+$monthleave->apprSick + $monthleave->other; //total leave add
                            // dd($monthFingerAbsunt,$totalLeave);
                        if ($monthFingerAbsunt > $totalLeave) {
                            // dd("kkkkk");
                            $netLeave = $monthFingerAbsunt - $totalLeave; //leave diffrance machine and leave compare
                            if ($monthleave->other != null) {
                                $monthleave->other = $monthleave->other + $netLeave;
                            } else {
                                $monthleave->other = $netLeave;
                            }
                        }
                        $monthleave->status = 3;
                        $monthleave->save();
                    }
            */

            // ----------------------leave to other leave shift ------------------//monthLeave In status 0 Update Function

            $monthleave = monthleave::where('user_id', $user->id)->where('to', $lastMonthofDay)->where('status', 0)->first();
            dd($monthleave->toArray());
            if ($monthleave->apprAnual > $monthleave->anualLeave) {
                $netleaveAnual = $monthleave->apprAnual - $monthleave->anualLeave;
                if ($monthleave->other != null) {
                    $monthleave->other = $monthleave->other + $netleaveAnual;
                } else {
                    $monthleave->other = $netleaveAnual;
                }
            }
            if ($monthleave->apprSick > $monthleave->sickLeave) {
                $netleaveAnual = $monthleave->apprSick - $monthleave->sickLeave;
                if ($monthleave->other != null) {
                    $monthleave->other = $monthleave->other + $netleaveAnual;
                } else {
                    $monthleave->other = $netleaveAnual;
                }
            }
            $monthleave->save();
            
            $monthleave = monthleave::where('user_id', $user->id)->where('to', $lastMonthofDay)->where('status', 0)->first();
            $monthdata = $monthleave;
            dd($monthdata);
            // --------------------new row create user in next month controle---------------------//get a new entery month in user
            $session = Session::where('status', 1)->first();
            $fristMonthofDay = Carbon::now()->startOfMonth()->toDateString();
            $lastMonthofDay = Carbon::now()->endOfMonth()->toDateString();
            $monthleave = new monthleave();
            $monthleave->user_id = $user->id;
            $monthleave->useryear_id = $session->id;
            if ($fristMonthofDay>=$user->joiningDate) {
                $monthleave->from = $user->joiningDate;
                
            }else{
                $monthleave->from = $fristMonthofDay;
            }
            if ($user->resignDate != null) {
                $monthleave->to = $user->resignDate;
            }else{

                $monthleave->to = $lastMonthofDay;
            }

            $anual = $monthdata->anualLeave - $monthdata->apprAnual;
            if ($anual > 0) {
                foreach ($leavet as $leave) {
                    if ($leave->type == "PL") {
                        $day = $leave->day / 12;
                        $monthleave->anualLeave = $anual + $day;
                        $monthleave->carry_pl_leave = $anual;
                    }
                }
            } else {
                foreach ($leavet as $leave) {
                    if ($leave->type == "PL") {
                        $day = $leave->day / 12;
                        $monthleave->anualLeave = $day;
                        $monthleave->carry_pl_leave = $anual;
                    }
                }
            }
            $sick = $monthdata->sickLeave - $monthdata->apprSick; //due day sick
            if ($sick > 0) {
                foreach ($leavet as $leave) {
                    if ($leave->type == "Sick") {
                        $day = $leave->day / 12;
                        $monthleave->sickLeave = $sick + $day;
                        $monthleave->carry_sick_leave = $sick;
                    }
                }
            } else {
                foreach ($leavet as $leave) {
                    if ($leave->type == "Sick") {
                        $day = $leave->day / 12;
                        $monthleave->sickLeave = $day;
                        $monthleave->carry_sick_leave = $sick;
                    }
                }
            }
            $monthleave->status = 1;
            $monthleave->save();
        }
    
}
