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
    public function empreport(){    
        $first_date = Carbon::createFromDate()->startOfMonth()->subMonths()->toDateString();
        $last_date = Carbon::createFromDate()->subMonths()->endOfMonth()->toDateString();
        // dd($first_date,$last_date);  
        $monthRecord = User::with(['monthleavesalary' => function($query)use($first_date,$last_date){
            $query->where('from','>=',$first_date)->where('to','<=',$last_date);
        },'designation'])->orderBy('users.first_name')->where('status',1)->get();
        
        $users = User::with('usersalaryget')->where('status', 1)->select('id', 'first_name')->get();
    //   dd($monthRecord->toArray());
        return view('admin.report.leavereport', compact('users','monthRecord'));
    }
    ///empreport
    public function empreportSearch(Request $request){
        $first_date = Carbon::createFromDate($request->year,$request->month)->startOfMonth()->toDateString();
        $last_date = Carbon::createFromDate($request->year,$request->month)->endOfMonth()->toDateString();
        if (!empty($request->user_id)) {
           $monthRecord = User::with(['monthleavesalary' => function($query)use($first_date,$last_date){
               $query->where('from','>=',$first_date)->where('to','<=',$last_date)->where('status',0);
           }])->orderBy('users.first_name')->where('id',$request->user_id)->get();
        }else{
            $monthRecord = User::with(['monthleavesalary' => function($query)use($first_date,$last_date){
                $query->where('from','>=',$first_date)->where('to','<=',$last_date)->where('status',0);
            },'designation'])->orderBy('users.first_name')->get();
        }
        $users = User::with('usersalaryget')->where('status', 1)->select('id', 'first_name')->get();
              return view('admin.report.leavereport', compact('users', 'monthRecord'));
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
    public function monthRecordLeaveManage($id=""){
        if (!empty($id)){
                $monthLeavereport= monthleave::where('user_id',$id)->where('status',0)->get();
                $monthLeavereportCount= monthleave::where('user_id',$id)->where('status',0)->count();
            if ($monthLeavereportCount) {           
                foreach ($monthLeavereport as $monthLeave) {          
                    $monthReport= Attendance::where('user_id',$monthLeave->user_id)->where('date','>=',$monthLeave->from)->where('date','<=',$monthLeave->to)->get();
                    $monthReportCount= Attendance::where('user_id',$monthLeave->user_id)->where('date','>=',$monthLeave->from)->where('date','<=',$monthLeave->to)->count();
                    if (!empty($monthReportCount)) {      
                        $absent=0;
                    $workingDay =0;
                    $halfDayOf =0;
                    $leaves= 0;
                    $totalLeaveDue=0;
                    foreach ($monthReport as $status) {
                        if ($status->mark == "A") {
                            $absent=$absent+1;
                        }elseif($status->mark == "P" || $status->mark=="WFH"){
                            $workingDay=$workingDay+1;
                        }elseif($status->mark=="HDO"){
                            $halfDayOf = $halfDayOf+0.5;
                        }elseif($status->mark=="L"){
                            $leaves=  $leaves+1;
                        }
                        $monthLeaveReport = monthleave::find($monthLeave->id);
                        $leave=$monthLeaveReport->anualLeave+$monthLeaveReport->sickLeave;
                        $other=0;
                                if ($leaves<=$leave) {
                                    if($leaves<=$monthLeaveReport->anualLeave) {
                                        $monthLeaveReport->apprAnual=$leaves;
                                    }else{
                                        $monthLeaveReport->apprAnual=$monthLeaveReport->anualLeave;
                                        $netday=$leaves-$monthLeaveReport->anualLeave;
                                        $monthLeaveReport->apprSick=$netday;
                                    }
                                }else{
                                    $other=$leaves-$leave;
                                    $monthLeaveReport->apprAnual=$monthLeaveReport->anualLeave;
                                    $monthLeaveReport->apprSick=$monthLeaveReport->sickLeave;
                                }                   
                            $monthLeaveReport->other=$absent+$halfDayOf+$totalLeaveDue+$other;
                            $monthLeaveReport->working_day=$halfDayOf+$workingDay;
                            $monthLeaveReport->status=3;
                            $monthLeaveReport->save();         
                        }   
                    }else{
                        $monthLeaveReport = monthleave::find($monthLeave->id);
                        $monthLeaveReport->other=0;
                        $monthLeaveReport->working_day=0;
                        $monthLeaveReport->status=3;
                        $monthLeaveReport->save(); 
                    }
                }
                $ids= monthleave::where('user_id',$id)->where('status',3)->latest()->max('id');
                $settinfLeave= settingleave::where('status',1)->get();
                $monthleaveUpdate= monthleave::find($ids);                    
                $pl =$monthleaveUpdate->anualLeave-$monthleaveUpdate->apprAnual;
                $sick=$monthleaveUpdate->sickLeave-$monthleaveUpdate->apprSick;
                $monthleaveUpdateRecord= monthleave::where('user_id',$id)->where('status',1)->first();
                $monthleaveUpdateRecord->carry_pl_leave=$pl;
                $monthleaveUpdateRecord->carry_sick_leave=$sick;
                foreach ($settinfLeave as $leave) {                        
                    if ($leave->type=="PL") {
                        $day= $leave->day/12;
                        $monthleaveUpdateRecord->monthpl=$day;
                    }
                    if($leave->type=="Sick"){
                        $day= $leave->day/12;
                        $monthleaveUpdateRecord->monthsick=$day;
                    }
                }
                $monthleaveUpdateRecord->anualLeave=$monthleaveUpdateRecord->monthpl+$pl;
                $monthleaveUpdateRecord->sickLeave=$monthleaveUpdateRecord->monthsick+$sick;
                $monthleaveUpdateRecord->save();
            }
            }else{
                    $users= user::all('id');
                foreach ($users as $userid) {
                $id=$userid->id;
                $monthLeavereport= monthleave::where('user_id',$id)->where('status',0)->get();
                $monthLeavereportCount= monthleave::where('user_id',$id)->where('status',0)->count();
                    if (!empty($monthLeavereportCount)) {         
                          foreach ($monthLeavereport as $monthLeave) {          
                            $monthReport= Attendance::where('user_id',$monthLeave->user_id)->where('date','>=',$monthLeave->from)->where('date','<=',$monthLeave->to)->get();
                            $monthReportCount= Attendance::where('user_id',$monthLeave->user_id)->where('date','>=',$monthLeave->from)->where('date','<=',$monthLeave->to)->count();
                            if (!empty($monthReportCount)) {      
                                $absent=0;
                            $workingDay =0;
                            $halfDayOf =0;
                            $leaves= 0;
                            $totalLeaveDue=0;
                            foreach ($monthReport as $status) {
                                if ($status->mark == "A") {
                                    $absent=$absent+1;
                                }elseif($status->mark == "P" || $status->mark=="WFH"){
                                    $workingDay=$workingDay+1;
                                }elseif($status->mark=="HDO"){
                                    $halfDayOf = $halfDayOf+0.5;
                                }elseif($status->mark=="L"){
                                    $leaves=  $leaves+1;
                                }
                                $monthLeaveReport = monthleave::find($monthLeave->id);
                                $leave=$monthLeaveReport->anualLeave+$monthLeaveReport->sickLeave;
                                $other=0;
                                        if ($leaves<=$leave) {
                                            if($leaves<=$monthLeaveReport->anualLeave) {
                                                $monthLeaveReport->apprAnual=$leaves;
                                            }else{
                                                $monthLeaveReport->apprAnual=$monthLeaveReport->anualLeave;
                                                $netday=$leaves-$monthLeaveReport->anualLeave;
                                                $monthLeaveReport->apprSick=$netday;
                                            }
                                        }else{
                                            $other=$leaves-$leave;
                                            $monthLeaveReport->apprAnual=$monthLeaveReport->anualLeave;
                                            $monthLeaveReport->apprSick=$monthLeaveReport->sickLeave;
                                        }                   
                                    $monthLeaveReport->other=$absent+$halfDayOf+$totalLeaveDue+$other;
                                    $monthLeaveReport->working_day=$halfDayOf+$workingDay;
                                    $monthLeaveReport->status=3;
                                    $monthLeaveReport->save();         
                                }   
                            }else{
                                $monthLeaveReport = monthleave::find($monthLeave->id);
                                $monthLeaveReport->other=0;
                                $monthLeaveReport->working_day=0;
                                $monthLeaveReport->status=3;
                                $monthLeaveReport->save(); 
                            }
                        }
                        $id= monthleave::where('user_id',$id)->where('status',3)->latest()->max('id');
                        $settinfLeave= settingleave::where('status',1);
                        $monthleaveUpdateRecord= monthleave::where('user_id',$id)->where('status',1)->first();
                        $monthleaveUpdate= monthleave::find($id);
                        $pl =$monthleaveUpdate->anualLeave-$monthleaveUpdate->apprAnual;
                        $sick=$monthleaveUpdate->sickLeave - $monthleaveUpdate->apprSick;
                        $monthleaveUpdateRecord->carry_pl_leave=$pl;
                        $monthleaveUpdateRecord->carry_sick_leave=$sick;
                        foreach ($settinfLeave as $leave) {
                            if ($leave->type=="PL") {
                                $day= $leave->day/12;
                                $monthleaveUpdateRecord->anualLeave=$pl+$day;
                            }elseif($leave->type=="Sick"){
                                $day= $leave->day/12;
                                $monthleaveUpdateRecord->sickLeave=$day+$sick;
                            }
                        }
                        $monthleaveUpdateRecord->save();
                    }
            }
        }
      
    return redirect()->back();
    }
}
