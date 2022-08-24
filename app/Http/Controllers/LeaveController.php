<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave\Leave;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use App\Models\Leave\settingleave;
use App\Models\Admin\UserleaveYear;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave\Leaverecord;
use App\Models\monthleave;
use App\Models\WorkFromHome;
use Facade\FlareClient\Glows\Recorder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
class LeaveController extends Controller
{
    //    ------------------------employees function ----------------------

    public function leave()
    {
        $session = Session::where('status', 1)->first();
        $allfrom = $session->from;
        $allto = $session->to;
        $firstDayofMonth = Carbon::now()->startOfMonth()->toDateString();
        $lastDayofMonth = Carbon::now()->endOfMonth()->toDateString();
        $month = monthleave::where('user_id', Auth::guard('web')->user()->id)->where('status', 1)->first();
        $data = Leave::with('leaverecordEmp', 'leaveType')->where('user_id', Auth::guard('web')->user()->id)->where(function ($query) use ($firstDayofMonth, $lastDayofMonth) {
            $query->where("form", ">=", $firstDayofMonth);
        })->latest()->get();
        $ptotalMonthLeave = Leave::where('user_id', Auth::guard('web')->user()->id)->where('status', 2)->with('leaveType')->where(function ($query) use ($firstDayofMonth, $lastDayofMonth) {
            $query->where("form", ">=", $firstDayofMonth)->where("to", "<=", $lastDayofMonth);
        })->get();
        $totalLeave = Leaverecord::where('user_id', Auth::guard('web')->user()->id)->where('status', 1)->where(function ($query) use ($allfrom, $allto) {
            $query->where("from", ">=", $allfrom)->where("to", "<=", $allto);
        })->with('leavetype')->get();
        $wfh =WorkFromHome::where('user_id',Auth::guard('web')->user()->id)->orderBy('id','DESC')->get();
        $allDay = 0;
        foreach ($totalLeave as $key => $days) {
            $allDay = $allDay + $days->day;
        }
        // dd($data->toArray());
        return view('employees.leave.leave', compact('data', 'month', 'ptotalMonthLeave', 'allDay','wfh'));
    }
    public function wfhcreate(){
        return view('employees.leave.add-wfh');
    }
    public function wfhstore(Request $request){
        $dateFrom = new DateTime($request->form);
        $dateTo = new DateTime($request->to);
        $interval = $dateFrom->diff($dateTo);
        $da = $interval->format('%a');
        $days = $da + 1;

        $workfrom = new WorkFromHome();
            $workfrom->user_id = $request->user_id;
            $workfrom->from = $request->from;
            $workfrom->to = $request->to;

             //sunday and saturday count in request->from to request->to
             $day = Carbon::createFromFormat('Y-m-d', $request->from);
             $ssfrom = date('d',strtotime($day));
             $ssto = date('d',strtotime($request->to));
             $sunday = 0;
             $saturday = 0;          
             foreach(range($ssfrom,$ssto) as $key => $next) {
                 if (strtolower($day->format('l')) == 'sunday') {
                     $sunday++;
                    }
                    //saturday Count first And third
                    $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
                    $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
                    if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d"))) {
                        $saturday++;
                    }
                    $day = $day->addDays();
             }
             $days=$days-$sunday;
             $days=$days-$saturday;
             $hfrom=$request->from;
             $hto =$request->to;
             $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
             $days=$days-$holiday;           
            $workfrom->day =$days;
            $workfrom->task = $request->task;
            $workfrom->status =2;
            $workfrom->save();
            return redirect()->back();
    }
    public function leaveadd()
    {
        $data = settingleave::all();
        return view('employees.leave.add-leave', compact('data'));
    }
    //leave store Function 
    public function storeleave(Request $request)
    {
        $first_date = date('Y-m-d', strtotime('first day of this month'));
        $last_date = date('Y-m-d', strtotime('last day of this month'));
        $rules = [
            'type_id' => ['required', 'integer'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
            'reason' => ['required', 'string'],
        ];
        $date = date('Y-m-d', strtotime($request->from));
        $nowdate = date('Y-m-d', strtotime(now()));
        if ($date <= $nowdate) {
            return back()->withErrors(["from" => "Please Select From date"])->withInput();
        }
        if (date('Y-m-d', strtotime($request->to)) < $date) {
            return back()->withErrors(["to" => "Please Select to date"])->withInput();
        }
        $request->validate($rules);
        $data = new Leave();
        $data->user_id = Auth::guard('web')->user()->id;
        $leavetype = settingleave::where('id', $request->type_id)->count();
        if ($leavetype > 0) {
            $data->leaves_id = $request->type_id;
        } else {
            return back()->withErrors(["type_id" => "Please Select Leave Type"])->withInput();
        }
        $date = now();
        $fromdate = date("Y-m-d", strtotime("$date + 30 day"));
        if ($request->from <= $fromdate) {
            $data->form = date('Y-m-d', strtotime($request->from));
            $todate = date("Y-m-d", strtotime("$request->from + 30 day"));
            if ($request->to <= $todate) {
                $data->to = date('Y-m-d', strtotime($request->to));
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        };
        $leave = "";
        if ($leave > 0) {
            return back()->withErrors(["from" => "Please Select another From date"])->withInput();
        }
        $data->reason = $request->reason;
        $dateFrom = new DateTime($request->from);
        $dateTo = new DateTime($request->to);
        $interval = $dateFrom->diff($dateTo);
        $da = $interval->format('%a');
        $days = $da + 1;
        $data->day = $days;
        $leavemonth = Leave::where('leaves_id', $request->type_id)->where('user_id', Auth::guard('web')->user()->id)->whereMonth('form', date('m'))->whereYear('form', date('Y'))->get();
        $start = date('Y-m-d', strtotime(Auth::guard('web')->user()->joiningDate));
        $end = date('Y-m-d');
        $interval = Carbon::parse($start)->DiffInMonths($end);
        $data->status = 2;
        $data->save();
        return redirect()->route('employees.leave');
    }


    // --------------delete function-----------------------
    public function delete($id)
    {
        $data = Leave::find($id);
        if ($data->status == 1) {
            return back()->with(["unsuccess" => "Don't Delete This Record"])->withInput();
        } else {
            $leaverecord = Leaverecord::where('leave_id', $id)->get();
            foreach ($leaverecord as $record) {
                $record->delete();
            }
            $data->delete();
            return back()->with(["success" => "Success Delete This Record"])->withInput();
        }
    }
    //leave fnction Store
    public function attendance(Request $request){  
        $rules = [
            'id' => ['required', 'integer'],
            'day' => ['required', 'integer'],
            'leaveType' => ['required', 'integer'],
            'reson' => ['required', 'max:250'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ];
        $request->validate($rules);
        $attendance = Attendance::find($request->id);
        $leaveApproved = $attendance->date;
        $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where("form", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->count();
        // dd($leavePending);
        if ($leavePending == 0) {
            $data = new Leave();
            $data->user_id = Auth::guard('web')->user()->id;
            $data->leaves_id = $request->leaveType;
            $data->form = $attendance->date;
            $data->to = $attendance->date;
            $data->reason = $request->reson;
            $data->day = 1;
            $data->status = 2;
            $data->save();          
        }
        $attendance->action = 3;
        $attendance->save();
        return redirect()->route('employees.leave');
    }
    //wfh Request Store Function 
    public function attendanceWfhStore(Request $request)
    {
        dd($request->toArray());
        $rules = [
            'id' => ['required', 'integer'],
            'day' => ['required', 'integer'],
            'task' => ['required', 'max:250'],
            'wdate' => ['required', 'date'],
        ];
        $attendance = Attendance::find($request->id);
        $leaveApproved = $attendance->date;
        $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where(function ($query) use ($leaveApproved) {
            $query->where("form", ">=", $leaveApproved)->where("to", "<=", $leaveApproved);
        })->count();
        $request->validate($rules);
        $wfh = WorkFromHome::where('user_id', Auth::guard('web')->user()->id)->where('from','>=',$leaveApproved)->where('to','<=',$leaveApproved)->count();
        if ($leavePending == 0 && $wfh == 0) {
            $data = new WorkFromHome();
            $data->user_id = Auth::guard('web')->user()->id;
            $data->from = $attendance->date;
            $data->to =  $attendance->date;     
            $data->day = 1;
            $data->task = $request->task;
            $data->status = 2;
            $data->save();
            $attendance->action = 4;
            $attendance->save();
        }
        return redirect()->route('employees.leave');
    }
    //Leave With WFH Request Function 
    public function attendanceLeaveWfhStore(Request $request)
    {       
        $rules = [
            'id' => ['required', 'integer'],
            'day' => ['required', 'integer'],
            'task' => ['required', 'max:250'],
            'wdate' => ['required', 'date'],
        ];
        $attendance = Attendance::find($request->id);
        $leaveApproved = $attendance->date;
        $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where("form", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
        $leaveApprovedRecord=Leaverecord::where('user_id', Auth::guard('web')->user()->id)->where("from", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
        $request->validate($rules);
        if ($leavePending != null) {  
            $days=1;
                $leaveType = settingleave::find($leaveApprovedRecord->type_id);
                $monthLeave = monthleave::where('status', 1)->where('user_id', Auth::guard('web')->user()->id)->latest()->first();
                if ($leaveType->type == "PL") {
                    $monthLeave->apprAnual = $monthLeave->apprAnual -$days;
                } elseif ($leaveType->type == "PL") {
                    $monthLeave->apprSick = $monthLeave->apprSick -$days;
                } else {
                    $monthLeave->other = $monthLeave->other - $days;
                }
                $monthLeave->save();
            $leaveApprovedRecord->day = $leaveApprovedRecord->day-$days;
            $leaveApprovedRecord->save();
            $leavePending->day=$leavePending->day-$days;
            $leavePending->save();
        }
        $wfh = WorkFromHome::where('user_id', Auth::guard('web')->user()->id)->where('date', $leaveApproved)->count();
        if ($leavePending != null && $wfh == 0) {
            $data = new WorkFromHome();
            $data->user_id = Auth::guard('web')->user()->id;
            $data->from = $attendance->date;
            $data->to = $attendance->date;           
            $data->day =1;
            $data->task = $request->task;
            $data->status =2;
            $data->save();           
            $attendance->action = 5;
            $attendance->save();
        }
        return redirect()->back();
    }


    public function attendanceLeave($id)
    {
        $leaveApply = Attendance::find($id);
        return response()->json(['attendleave' => $leaveApply]);
    }
    // ----------------------------admin leave function-----------------------------

}
