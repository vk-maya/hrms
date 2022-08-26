<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\monthleave;
use App\Models\Leave\Leave;
use App\Models\WorkFromHome;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use App\Models\Leave\Leaverecord;
use App\Models\Leave\settingleave;
use App\Models\Admin\UserleaveYear;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LeaveController;

class AdminLeaveController extends Controller
{
    public function edit($id)
    {
        $data = Leave::find($id);
        $type = settingleave::all();
        return view('admin.leave.edit-leave', compact('data', 'type'));
    }

    public function update(Request $request)
    {
        $data = Leave::find($request->id);
        $leavetype = settingleave::where('id', $request->type)->count();
        if ($leavetype > 0) {
            $data->leaves_id = $request->type;
        } else {
            return back()->withErrors(["type_id" => "Please Select Leave Type"])->withInput();
        }
        $date = now();
        $fromdate = date("Y-m-d", strtotime("$date + 30 day"));
        if ($request->from <= $fromdate) {
            $data->form = date('Y-m-d', strtotime($request->from));
            $todate = date("Y-m-d", strtotime("$request->from + 30 day"));
            if ($request->to <= $todate){
                $data->to = date('Y-m-d', strtotime($request->to));
            }else{

                return redirect()->back()->withErrors(["to" => "Please Select to Date Type"])->withInput();

            }
        }else{

            return redirect()->back()->withErrors(["from" => "Please Select Leave Type"])->withInput();
        }
        $leave = Leave::where('user_id', $request->user_id)->where(function ($query) use ($request) {
            $query->where('form', '<=', $request->from)->where('to', '>=', $request->from);
        })->orWhere(function ($query) use ($request) {
            $query->where('form', '<=', $request->to)->where('to', '>=', $request->to);
        })->where('id', "!=", $request->id)->count();
        if ($leave > 0) {
            return back()->withErrors(["from" => "Please Select another From date"])->withInput();
        }
        $data->reason = $request->reason;
        $data->save();
        return redirect()->route('admin.leave.list');
    }
    //holiday Function
    public function holidays(Request $request)
    {
        if ($request->id != '') {
            $holi = Holiday::find($request->id);
            $data = Holiday::all();
            return view('admin.leave.holiday', compact('holi', 'data'));
        } else {
            $data = Holiday::all();
            return view('admin.leave.holiday', compact('data'));
        }
    }
    //leave delete Function
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

    //holiday store function
    public function holidayStore(Request $request)
    {
        $rules = [
            'name' => ['required', 'string'],
            'date' => ['required', 'date'],

        ];
        if ($request->id != "") {
            $data = Holiday::find($request->id);
        } else {
            $data = new Holiday();
        }
        $request->validate($rules);

        $session = Session::where('status', 1)->first();

        $data->session_id = $session->id;
        $data->holidayName = $request->name;
        $data->date = $request->date;
        $data->status = 1;
        $data->save();
        return redirect()->route('admin.holidays');
    }
    //holiday delete Function
    public function holidaydistroy($id)
    {
        $data = Holiday::find($id)->delete();
        return redirect()->back();
    }
    //leave Setting Function
    public function leavesetting()
    {
        return view('admin.leave.leave-setting');
    }
    //leave List
    public function leavelist()
    {
        $data = Leave::with(['user' => function ($query) {$query->where('status', 1);}])->with('leaverecord')->latest()->get();
        $leaveCount = Leave::with(['user' => function ($query) {$query->where('status', 1);}])->where('status',2)->count();
        $wfhData = WorkFromHome::with(['user' => function ($query) {$query->where('status', 1);}])->orderBy('id', 'DESC')->get();
        $wfhcount = WorkFromHome::with(['user' => function ($query) {$query->where('status',1);}])->where('status',2)->count();
        return view('admin.leave.leave', compact('data','wfhData','wfhcount','leaveCount'));
    }

    public function leavetype(Request $request)
    {
        $type = settingleave::where('type', $request->type)->get();
        $rules = [
            'day' => ['required', 'string'],
        ];
        $sesssion = Session::where('status', 1)->latest()->first();
        $data = new settingleave();
        $data->session_id = $sesssion->id;
        $data->type = $request->type;
        $data->day = $request->day;
        $data->status = 1;
        $data->save();
        return redirect()->back();
    }

    //leave report by admin status update
    public function leavereport(Request $request) {
        $data = Leave::find($request->id);
        //leave record save datatable
        $userLeave = Leave::find($request->id);
        $userLeave->admin_id =Auth::guard('admin')->user()->id;;
        $dateFrom = new DateTime($userLeave->form);
        $dateTo = new DateTime($userLeave->to);
        $interval = $dateFrom->diff($dateTo);
        $da = $interval->format('%a');
        $days = $da + 1;
        $firstMonthofDay =  Carbon::now()->startOfMonth()->toDateString(); //Current month Range
        $lastMonthofDay = Carbon::now()->endOfMonth()->toDateString();
        $nextMonthFirstfDay =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(1)->toDateString(); //second month Range
        $nextToNextMonthFirstfDay =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2)->toDateString(); //last and 3 range month
        $request->reason=$userLeave->reason;
        $request->from=$userLeave->form;
        $request->to=$userLeave->to;
        $request->type_id=$userLeave->leaves_id;
        $leaveOfMOnth = monthleave::where('user_id',$userLeave->user_id)->where('status', 1)->first();
        $leaveType = settingleave::find($request->type_id);
        $from=$request->from;
        $to =$request->to;
        $leaverecord = Leaverecord::where('user_id',$data->user_id)->get();
        $leaverecordCount = Leaverecord::where('leave_id',$request->id)->count();
            if ($request->status ==1 && $leaverecordCount == 0) {
                    if ($request->from >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $request->from;
                        $leaveRecord->to = $request->to;
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
                        $leaveRecord->day =$days;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status =1;
                        $leaveRecord->admin_id =Auth::guard('admin')->user()->id;

                        $leaveRecord->save();
                    } elseif ($request->from <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
                        $lastMonthofDayD = Carbon::now()->endOfMonth();
                        $diffDay = $dateFrom->diff($lastMonthofDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $daysnl = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->from = $request->from;
                        $leaveRecord->to = $lastMonthofDay;
                        //sunday and saturady count function
                        $day = Carbon::createFromFormat('Y-m-d', $request->from);
                        $ssfrom = date('d',strtotime($day));
                        $ssto = date('d',strtotime($lastMonthofDay));
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
                        $hfrom=$request->from;
                        $hto=$lastMonthofDay;
                        $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
                        $daysn=$daysn-$sunday;
                        $daysn=$daysn-$saturday;
                        $daysn=$daysn-$holiday;
                        $leaveRecord->day = $daysn;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status =1;
                        $leaveRecord->admin_id =Auth::guard('admin')->user()->id;
                        $leaveRecord->save();
                        $NewRecord = $days - $daysnl;
                        if ($NewRecord > 0) {
                            $lastMonthofDays = Carbon::now()->endOfMonth();
                            $fromNewDate = $lastMonthofDays->addDay(1)->toDateString();
                            $newTodate= $request->to;
                            $leaveRecord = new Leaverecord();
                            $leaveRecord->user_id = $userLeave->user_id;
                            $leaveRecord->leave_id = $userLeave->id;
                            $leaveRecord->type_id = $userLeave->leaves_id;
                            $leaveRecord->from = $fromNewDate;
                            $leaveRecord->to = $request->to;
                            //sunday and saturady count function
                            $day = Carbon::createFromFormat('Y-m-d', $fromNewDate);
                            $dayss = Carbon::createFromFormat('Y-m-d', $fromNewDate);
                            $ssfrom = date('d',strtotime($day));
                            $ssto = date('d',strtotime($request->to));
                            $smonth = date('Y-m',strtotime($day));
                            $sunday = 0;
                            $saturday = 0;
                            foreach(range($ssfrom,$ssto) as $key => $next) {
                                if (strtolower($day->format('l')) == 'sunday') {
                                    $sunday++;
                                    }
                                    //saturday Count first And third
                                    $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
                                    $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
                                    $satn1 = Carbon::parse('first saturday of next month')->format('Y-m-d');
                                    $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
                                    if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d") || $satn3 == $day->format("Y-m-d") || $satn1 == $day->format("Y-m-d"))) {
                                        $saturday++;
                                    }
                                    $day = $day->addDays();
                                }
                            $hfrom=$fromNewDate;
                            $hto=$request->to;
                            $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
                            $NewRecord=$NewRecord-$sunday;
                            $NewRecord=$NewRecord-$saturday;
                            $NewRecord=$NewRecord-$holiday;
                            $leaveRecord->day = $NewRecord;
                            $leaveRecord->reason = $request->reason;
                            $leaveRecord->status =1;
                            $leaveRecord->admin_id =Auth::guard('admin')->user()->id;
                            $leaveRecord->save();
                        }
                    } elseif ($request->from > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {

                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->from = $request->from;
                        $leaveRecord->to = $request->to;
                            //sunday and saturady count function
                            $day = Carbon::createFromFormat('Y-m-d', $request->from);
                            $ssfrom = date('d',strtotime($day));
                            $ssto = date('d',strtotime($request->to));
                            $smonth = date('Y-m',strtotime($day));
                            $sunday = 0;
                            $saturday = 0;
                            foreach(range($ssfrom,$ssto) as $key => $next) {
                                if (strtolower($day->format('l')) == 'sunday') {
                                    $sunday++;
                                    }
                                    //saturday Count first And third
                                    $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
                                    $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
                                    $satn1 = Carbon::parse('first saturday of next month')->format('Y-m-d');
                                    $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
                                    if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d") || $satn3 == $day->format("Y-m-d") || $satn1 == $day->format("Y-m-d"))) {
                                        $saturday++;
                                    }
                                    $day = $day->addDays();
                                }
                        $hfrom=$request->from;
                        $hto=$request->to;
                        $holiday= Holiday::where('status',1)->where(function($query)use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
                        $days=$days-$sunday;
                        $days=$days-$saturday;
                        $days=$days-$holiday;
                        $leaveRecord->day =$days;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status =1;
                        $leaveRecord->admin_id =Auth::guard('admin')->user()->id;
                        $leaveRecord->save();
                    } elseif ($request->from >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
                        $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                        $diffDay = $dateFrom->diff($nextToMonthLastDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $daysl = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $request->from;
                        $leaveRecord->to = $nextToMonthLastDayD;
                        //sunday and saturady count function
                        $day = Carbon::createFromFormat('Y-m-d', $request->from);
                        $ssfrom = date('d',strtotime($request->from));
                        $ssto = date('d',strtotime($nextToMonthLastDayD));
                        $smonth = date('Y-m',strtotime($day));
                        $sunday = 0;
                        $saturday = 0;
                        foreach(range($ssfrom,$ssto) as $key => $next) {
                            if (strtolower($day->format('l')) == 'sunday') {
                                $sunday++;
                            }
                            $day = $day->addDays();
                            //saturday Count first And third
                            $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
                            $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
                            $satn1 = Carbon::parse('first saturday of next month')->format('Y-m-d');
                            $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
                            if (strtolower($day->format('l')) == 'saturday' && ($sat1 == $day->format("Y-m-d") || $sat3 == $day->format("Y-m-d") || $satn3 == $day->format("Y-m-d") || $satn1 == $day->format("Y-m-d"))) {
                                $saturday++;
                            }
                        }
                        $hfrom=$request->from;
                        $hto=$nextToMonthLastDayD;
                        $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
                        $daysn=$daysn-$sunday;
                        $daysn=$daysn-$saturday;
                        $daysn=$daysn-$holiday;
                        $leaveRecord->day = $daysn;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status =1;
                        $leaveRecord->admin_id =Auth::guard('admin')->user()->id;
                        $leaveRecord->save();
                        $NewRecord = $days - $daysl;
                        if ($NewRecord > 0) {
                            $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2)->toDateString(); //last and 3 range month
                            $leaveRecord = new Leaverecord();
                            $leaveRecord->user_id = $userLeave->user_id;
                            $leaveRecord->type_id = $userLeave->leaves_id;
                            $leaveRecord->leave_id = $userLeave->id;
                            $leaveRecord->from = $lastMonthofDays;
                            $leaveRecord->to = $request->to;
                            //sunday and saturady count function
                            $day = Carbon::createFromFormat('Y-m-d',$lastMonthofDays);
                            $ssfrom = date('d',strtotime($day));
                            $ssto = date('d',strtotime($request->to));
                            $smonth = date('Y-m',strtotime($day));
                            $sunday = 0;
                            $saturday = 0;
                            foreach(range($ssfrom,$ssto) as $key => $next) {
                                if (strtolower($day->format('l')) == 'sunday') {
                                    $sunday++;
                                }
                                //saturday Count first And third
                                $sat1 = Carbon::parse('first saturday of this month')->format('Y-m-d');
                                $sat3 = Carbon::parse('third saturday of this month')->format('Y-m-d');
                                $satn1 =Carbon::parse('first saturday of next month')->format('Y-m-d');
                                $satn3 = Carbon::parse('third saturday of next month')->format('Y-m-d');
                                $satn4 = Carbon::parse("first saturday of second month")->format("Y-m-d");
                                $satn5 = Carbon::parse("third saturday of second month")->format("Y-m-d");
                                    if (strtolower($day->format('l')) == 'saturday' && ($satn4 == $day->format("Y-m-d") || $satn5 == $day->format("Y-m-d"))) {
                                        $saturday++;
                                        }
                                        $day = $day->addDays();
                            }
                            $hfrom=$lastMonthofDays;
                            $hto=$request->to;
                            $holiday= Holiday::where('status',1)->where(function($query) use ($hfrom,$hto){ $query->whereBetween('date',[$hfrom,$hto]);})->count();
                            $NewRecord=$NewRecord-$sunday;
                            $NewRecord=$NewRecord-$saturday;
                            $NewRecord=$NewRecord-$holiday;
                            $leaveRecord->day = $NewRecord;
                            $leaveRecord->reason = $request->reason;
                            $leaveRecord->status =1;
                            $leaveRecord->admin_id =Auth::guard('admin')->user()->id;
                            $leaveRecord->save();
                        }
                    }
                    $totaldayUpdate=Leaverecord::where('leave_id',$userLeave->id)->where('from',">=",$firstMonthofDay)->where('to',"<=",$lastMonthofDay)->get();
                    if ($totaldayUpdate != null) {
                        $totalLeaveDay=0;
                        foreach ($totaldayUpdate as $value) {
                            $totalLeaveDay=$totalLeaveDay+$value->day;
                        }
                        $userLeave->day=$totalLeaveDay;
                        $userLeave->status=1;
                        $leaveRecord->admin_id =Auth::guard('admin')->user()->id;
                        $userLeave->save(); 
                        $userLeave=Leave::where('id',$request->id)->first();
                    
                        $leaveType = settingleave::find($userLeave->leaves_id);
                        $monthLeaveRecord= monthleave::where('user_id',$userLeave->user_id)->where('status',1)->first();
                        $netLeaveAnuApp=$monthLeaveRecord->anualLeave-$monthLeaveRecord->apprAnual;
                        $netLeaveSickApp=$monthLeaveRecord->sickLeave-$monthLeaveRecord->apprSick;
                        if ($leaveType->type=="PL") {
                        if ($netLeaveAnuApp>=$userLeave->day){
                            $monthLeaveRecord->apprAnual=$monthLeaveRecord->apprAnual+$userLeave->day;
                        }else{
                        $monthLeaveRecord->apprAnual= $monthLeaveRecord->apprAnual+$netLeaveAnuApp;
                        $leaveAnual = $userLeave->day-$netLeaveAnuApp;
                        $monthLeaveRecord->other=$monthLeaveRecord->other+$leaveAnual;
                        }
                        }elseif($leaveType->type=="Sick"){
                            if ($netLeaveSickApp>=$userLeave->day){
                                $monthLeaveRecord->apprSick=$monthLeaveRecord->apprSick+$userLeave->day;
                            }else{
                            $monthLeaveRecord->apprSick= $monthLeaveRecord->apprSick+$netLeaveSickApp;
                            $leaveAnual = $userLeave->day-$netLeaveSickApp;
                            $monthLeaveRecord->other=$monthLeaveRecord->other+$leaveAnual;
                            }
                        }else{
                            $monthLeaveRecord->other=$monthLeaveRecord->other+$userLeave->day;
                        }
                        $monthLeaveRecord->save();
                    }else{
                        $userLeave->status=1;
                        $leaveRecord->admin_id =Auth::guard('admin')->user()->id;
                        $userLeave->save();
                    }
                    $attendance = Attendance::where('date',$from)->first();
                    if ($attendance!= null) {
                        $attendance->action = 1;
                        $attendance->mark="L";
                        $attendance->save();
                    }
            }elseif($request->status == 1 && $leaverecordCount > 0){
                    $totaldayUpdate=Leaverecord::where('leave_id',$request->id)->where('from',">=",$firstMonthofDay)->where('to',"<=",$lastMonthofDay)->get();
                if ($totaldayUpdate != null) { 
                    foreach ($totaldayUpdate as $value) {
                        $record =Leaverecord::find($value->id);
                        $record->status=1;
                        $record->admin_id =Auth::guard('admin')->user()->id;
                        $record->save();
                    }
                    $leaveType = settingleave::find($userLeave->leaves_id);
                    $monthLeaveRecord= monthleave::where('user_id',$userLeave->user_id)->where('status',1)->first();
                    $netLeaveAnuApp=$monthLeaveRecord->anualLeave-$monthLeaveRecord->apprAnual;
                    $netLeaveSickApp=$monthLeaveRecord->sickLeave-$monthLeaveRecord->apprSick;
                    if ($leaveType->type=="PL") {
                        if ($netLeaveAnuApp>=$userLeave->day){
                            $monthLeaveRecord->apprAnual=$monthLeaveRecord->apprAnual+$userLeave->day;
                        }else{
                        $monthLeaveRecord->apprAnual= $monthLeaveRecord->apprAnual+$netLeaveAnuApp;
                        $leaveAnual = $userLeave->day-$netLeaveAnuApp;
                        $monthLeaveRecord->other=$monthLeaveRecord->other+$leaveAnual;
                        }
                    }elseif($leaveType->type=="Sick"){
                        if ($netLeaveSickApp>=$userLeave->day){
                            $monthLeaveRecord->apprSick= $monthLeaveRecord->apprSick+$userLeave->day;
                        }else{
                        $monthLeaveRecord->apprSick= $monthLeaveRecord->apprSick+$netLeaveSickApp;
                        $leaveAnual = $userLeave->day-$netLeaveSickApp;
                        $monthLeaveRecord->other=$monthLeaveRecord->other+$leaveAnual;
                        }
                    }else{
                        $monthLeaveRecord->other=$monthLeaveRecord->other+$userLeave->day;
                    }
                    $monthLeaveRecord->save();
                $userLeave->status=1;
                $userLeave->save();
                }else{
                    $userLeave->status=1;
                    $userLeave->save();
                }
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action = 1;
                    $attendance->mark="L";
                    $attendance->save();
                }
            }elseif($request->status == 0 && $userLeave->status == 1){
                    $totaldayUpdate=Leaverecord::where('leave_id',$request->id)->where('from',">=",$firstMonthofDay)->where('to',"<=",$lastMonthofDay)->get();
                    if ($totaldayUpdate != null) { 
                        foreach ($totaldayUpdate as $value) {
                            $record =Leaverecord::find($value->id);
                            $record->status=0;
                            $record->admin_id =Auth::guard('admin')->user()->id;
                            $record->save();
                                }
                            $userLeave=Leave::where('id',$request->id)->first();
                            $leaveType = settingleave::find($userLeave->leaves_id);
                            $monthLeaveRecord= monthleave::where('user_id',$userLeave->user_id)->where('status',1)->first();
                            $netLeaveAnuApp=$monthLeaveRecord->apprAnual;
                            $netLeaveSickApp=$monthLeaveRecord->apprSick;
                    if ($leaveType->type=="PL") {
                            if ($netLeaveAnuApp>=$userLeave->day){
                                $monthLeaveRecord->apprAnual= $monthLeaveRecord->apprAnual-$userLeave->day;
                            }else{
                                $monthLeaveRecord->apprAnual=$netLeaveAnuApp;
                                $leaveAnual = $userLeave->day-$netLeaveAnuApp;
                                $monthLeaveRecord->other=$monthLeaveRecord->other-$leaveAnual;
                            }
                    }elseif($leaveType->type=="Sick"){
                            if ($netLeaveSickApp>=$userLeave->day){
                                $monthLeaveRecord->apprSick=$monthLeaveRecord->apprSick-$userLeave->day;
                            }else{
                            $monthLeaveRecord->apprSick=$netLeaveSickApp;
                            $leaveAnual = $userLeave->day-$netLeaveSickApp;
                            $monthLeaveRecord->other=$monthLeaveRecord->other-$leaveAnual;
                            }
                    }else{
                        $monthLeaveRecord->other=$monthLeaveRecord->other-$userLeave->day;
                    }
                    $monthLeaveRecord->save();
                    $userLeave->status=0;
                    $userLeave->save();
                }else{
                    $userLeave->status=0;
                    $userLeave->save();
                }
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action = 0;
                    $attendance->mark="A";
                    $attendance->save();
                }
            }elseif($request->status == 2 && $userLeave->status == 1){
                    $totaldayUpdate=Leaverecord::where('leave_id',$request->id)->where('from',">=",$firstMonthofDay)->where('to',"<=",$lastMonthofDay)->get();
                        if ($totaldayUpdate != null) { 
                        foreach ($totaldayUpdate as $value) {
                            $record =Leaverecord::find($value->id);
                            $record->status=0;
                            $record->admin_id =Auth::guard('admin')->user()->id;
                            $record->save();
                        }
                        $userLeave=Leave::where('id',$request->id)->first();
                        $leaveType = settingleave::find($userLeave->leaves_id);
                        $monthLeaveRecord= monthleave::where('user_id',$userLeave->user_id)->where('status',1)->first();
                        $netLeaveAnuApp=$monthLeaveRecord->apprAnual;
                        $netLeaveSickApp=$monthLeaveRecord->apprSick;
                        if ($leaveType->type=="PL") {
                            if ($netLeaveAnuApp>=$userLeave->day){
                                $monthLeaveRecord->apprAnual= $monthLeaveRecord->apprAnual-$userLeave->day;
                            }else{
                                $monthLeaveRecord->apprAnual=$netLeaveAnuApp;
                                $leaveAnual = $userLeave->day-$netLeaveAnuApp;
                                $monthLeaveRecord->other=$monthLeaveRecord->other-$leaveAnual;
                            }
                        }elseif($leaveType->type=="Sick"){
                            if ($netLeaveSickApp>=$userLeave->day){
                                $monthLeaveRecord->apprSick=$monthLeaveRecord->apprSick-$userLeave->day;
                            }else{
                            $monthLeaveRecord->apprSick=$netLeaveSickApp;
                            $leaveAnual = $userLeave->day-$netLeaveSickApp;
                            $monthLeaveRecord->other=$monthLeaveRecord->other-$leaveAnual;
                            }
                        }else{
                            $monthLeaveRecord->other=$monthLeaveRecord->other-$userLeave->day;
                        }
                        $monthLeaveRecord->save();
                        $userLeave->status=2;
                        $userLeave->save();
                    }else{
                        $userLeave->status=2;
                        $userLeave->save();
                    }
                    $attendance = Attendance::where('date',$from)->first();
                    if ($attendance!= null) {
                        $attendance->action = 2;
                        $attendance->mark="";
                        $attendance->save();
                    }
            }elseif($request->status == 0 && $userLeave->status == 2 && $leaverecordCount != null){
                    $totaldayUpdate=Leaverecord::where('leave_id',$request->id)->get();
                    foreach ($totaldayUpdate as $value) {
                        $record =Leaverecord::find($value->id);
                        $record->status=0;
                        $record->admin_id =Auth::guard('admin')->user()->id;
                        $record->save();     
                    }
                    $userLeave=Leave::where('id',$request->id)->first();
                    $userLeave->status=0;
                    $userLeave->save();
                    $attendance = Attendance::where('date',$from)->first();
                    if ($attendance!= null) {
                        $attendance->action = 0;
                        $attendance->mark="A";
                        $attendance->save();
                    }
            }elseif($request->status == 2 && $userLeave->status == 0 && $leaverecordCount != null){
                $userLeave=Leave::where('id',$request->id)->first();
                $userLeave->status=2;
                $userLeave->save();
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action = 2;
                    $attendance->mark="";
                    $attendance->save();
                }
            }elseif($request->status == 2 && $userLeave->status == 2 && $leaverecordCount ==0){
                $userLeave=Leave::where('id',$request->id)->first();
                $userLeave->status=2;
                $userLeave->save();
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action = 2;
                    $attendance->mark="";
                    $attendance->save();
                }
            }elseif($request->status == 0 && $userLeave->status == 2 && $leaverecordCount ==0){
                $userLeave=Leave::where('id',$request->id)->first();
                $userLeave->status=0;
                $userLeave->save();
                $attendance = Attendance::where('date',$from)->first();

                if ($attendance!= null) {
                    $attendance->action = 0;
                    $attendance->mark="A";
                    $attendance->save();
                }
            }
        return redirect()->back();
    }
    public function wfhReport(Request $request) {

        $data = WorkFromHome::where('user_id',$request->user_id)->where('id',$request->id)->first();
        $days =$data->day;
        $leaveApproved = $data->from;
        $from= $data->from;
        $totaldayUpdate=Leave::where('id',$request->id)->where('form',">=",$data->from)->where('to',"<=",$data->to)->get();
        $leaveCount=Leave::where('user_id',$request->user_id)->where('form',"<=",$data->from)->where('to',">=",$data->to)->count();
        // dd($leaveCount);
        if ($request->status==1 && $data != null) {            
            if ($data != null && $leaveCount == 0){
                $data->admin_id =Auth::guard('admin')->user()->id;
                $data->status=$request->status;
                $data->save();
            }else{                   
                    $attendance = Attendance::find($request->id);
                        $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where("form", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                        $leaveApprovedRecord=Leaverecord::where('user_id', Auth::guard('web')->user()->id)->where("from", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                        if ($leavePending != null) {                           
                                $leaveType = settingleave::find($leaveApprovedRecord->type_id);
                                $monthLeave = monthleave::where('status',1)->where('user_id', Auth::guard('web')->user()->id)->latest()->first();
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
                        $data->admin_id =Auth::guard('admin')->user()->id;
                        $data->status=$request->status;
                        $data->save();    
                }
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action = 1;
                    $attendance->mark="WFH";
                    $attendance->save();
                }
                
        }elseif($request->status==0 && $data->status== 2){
            $data->admin_id =Auth::guard('admin')->user()->id;
            $data->status=$request->status;
            $data->save();
            $attendance = Attendance::where('date',$from)->first();
            if ($attendance!= null) {
                $attendance->action =0;
                $attendance->mark="A";
                $attendance->save();
            }
        }elseif($request->status==0 && $data->status== 1){
            if ($data != null && $totaldayUpdate == null){
                $data->admin_id =Auth::guard('admin')->user()->id;
                $data->status=$request->status;
                $data->save();
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action =0;
                    $attendance->mark="A";
                    $attendance->save();
                }
            }else{
                    $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where("form", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    $leaveApprovedRecord=Leaverecord::where('user_id', Auth::guard('web')->user()->id)->where("from", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    if ($leavePending != null) {
                       
                            $leaveType = settingleave::find($leaveApprovedRecord->type_id);
                            $monthLeave = monthleave::where('status',1)->where('user_id', Auth::guard('web')->user()->id)->latest()->first();
                                if ($leaveType->type == "PL") {
                                    $monthLeave->apprAnual = $monthLeave->apprAnual +$days;
                                } elseif ($leaveType->type == "PL") {
                                    $monthLeave->apprSick = $monthLeave->apprSick +$days;
                                } else {
                                    $monthLeave->other = $monthLeave->other + $days;
                                }
                                    $monthLeave->save();
                                    $leaveApprovedRecord->day = $leaveApprovedRecord->day+$days;
                                    $leaveApprovedRecord->save();
                                    $leavePending->day=$leavePending->day+$days;
                                    $leavePending->save();
                    }
                                    $data->admin_id =Auth::guard('admin')->user()->id;
                                    $data->status=$request->status;
                                    $data->save();
                                    $attendance = Attendance::where('date',$from)->first();
                                    if ($attendance!= null) {
                                        $attendance->action =0;
                                        $attendance->mark="L";
                                        $attendance->save();
                                    }
            }         
        }elseif($request->status==1 && $data->status== 0){
            if ($data != null && $totaldayUpdate == null){
                $data->admin_id =Auth::guard('admin')->user()->id;
                $data->status=$request->status;
                $data->save();
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action =1;
                    $attendance->mark="WFH";
                    $attendance->save();
                }
            }else{
            
                    $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where("form", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    $leaveApprovedRecord=Leaverecord::where('user_id', Auth::guard('web')->user()->id)->where("from", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    if ($leavePending != null) {
                       
                            $leaveType = settingleave::find($leaveApprovedRecord->type_id);
                            $monthLeave = monthleave::where('status',1)->where('user_id', Auth::guard('web')->user()->id)->latest()->first();
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
                    $data->admin_id =Auth::guard('admin')->user()->id;
                    $data->status=$request->status;
                    $data->save();  
                    $attendance = Attendance::where('date',$from)->first();
                    if ($attendance!= null) {
                        $attendance->action =1;
                        $attendance->mark="WFH";
                        $attendance->save();
                    }  
            }
          
        }elseif($request->status==2 && $data->status== 1){      

            if ($data != null && $totaldayUpdate == null){
                $data->admin_id =Auth::guard('admin')->user()->id;
                $data->status=$request->status;
                $data->save();
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action =2;
                    $attendance->mark="";
                    $attendance->save();
                }
            }else{              
                    $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where("form", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    $leaveApprovedRecord=Leaverecord::where('user_id', Auth::guard('web')->user()->id)->where("from", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    if ($leavePending != null) {

                       
                            $leaveType = settingleave::find($leaveApprovedRecord->type_id);
                            $monthLeave = monthleave::where('status',1)->where('user_id', Auth::guard('web')->user()->id)->latest()->first();
                                if ($leaveType->type == "PL") {
                                    $monthLeave->apprAnual = $monthLeave->apprAnual +$days;
                                } elseif ($leaveType->type == "PL") {
                                    $monthLeave->apprSick = $monthLeave->apprSick +$days;
                                } else {
                                    $monthLeave->other = $monthLeave->other + $days;
                                }
                        $monthLeave->save();
                        $leaveApprovedRecord->day = $leaveApprovedRecord->day+$days;
                        $leaveApprovedRecord->save();
                        $leavePending->day=$leavePending->day+$days;
                        $leavePending->save();
                    }
                    $data->admin_id =Auth::guard('admin')->user()->id;
                    $data->status=$request->status;
                    $data->save();   
                    $attendance = Attendance::where('date',$from)->first();
                    if ($attendance!= null) {
                        $attendance->action =2;
                        $attendance->mark="L";
                        $attendance->save();
                    } 
            }         
        }elseif($request->status==2 && $data->status== 0){
            $data->admin_id =Auth::guard('admin')->user()->id;
            $data->status=$request->status;
            $data->save();
            $attendance = Attendance::where('date',$from)->first();
            if ($attendance!= null) {
                $attendance->action = 2;
                $attendance->mark="";
                $attendance->save();
            }
        }elseif($request->status==1 && $data->status== 2){
            if ($data != null && $totaldayUpdate == null){
                $data->admin_id =Auth::guard('admin')->user()->id;
                $data->status=$request->status;
                $data->save();
                $attendance = Attendance::where('date',$from)->first();
                if ($attendance!= null) {
                    $attendance->action = 1;
                    $attendance->mark="WFH";
                    $attendance->save();
                }
            }else{              
                    $leavePending = Leave::where('user_id', Auth::guard('web')->user()->id)->where("form", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    $leaveApprovedRecord=Leaverecord::where('user_id', Auth::guard('web')->user()->id)->where("from", "<=", $leaveApproved)->where("to", ">=", $leaveApproved)->first();
                    if ($leavePending != null) {
                       
                            $leaveType = settingleave::find($leaveApprovedRecord->type_id);
                            $monthLeave = monthleave::where('status',1)->where('user_id', Auth::guard('web')->user()->id)->latest()->first();
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
                    $data->admin_id =Auth::guard('admin')->user()->id;
                    $data->status=$request->status;
                    $data->save();  
                    $attendance = Attendance::where('date',$from)->first();
                    if ($attendance!= null) {
                        $attendance->action = 1;
                        $attendance->mark="WFH";
                        $attendance->save();
                    }
            }
        }      
        return redirect()->back();
    }
    public function moreleave($id)
    {
        $data = Leaverecord::where('leave_id', $id)->with('leavetype')->get();
        return view('admin.leave.leaverecord', compact('data'));
    }
}
