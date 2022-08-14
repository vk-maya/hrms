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
use App\Models\Leave\Leaverecord;
use App\Models\monthleave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;


class LeaveController extends Controller
{
    //    ------------------------employees function ----------------------

    public function leave()
    {

        $data = Leave::where('user_id', Auth::guard('web')->user()->id)->with('leaveType')->latest()->get();
        $leaveyear = UserleaveYear::where('user_id', Auth::guard('web')->user()->id)->latest()->first();
        $current = Leave::where('user_id', Auth::guard('web')->user()->id)->where('status', 1)->whereMonth('form', date('m'))->whereYear('form', date('Y'))->get();
        $session = Session::latest()->first();
        // dd($leaveyear);
        return view('employees.leave.leave', compact('data', 'leaveyear', 'current', 'session'));
    }
    public function leaveadd()
    {
        $data = settingleave::all();
        return view('employees.leave.add-leave', compact('data'));
    }
    public function storeleave(Request $request)
    {

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
            // dd($leavetyp);
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
        }
        $leave = Leave::where('user_id', Auth::guard('web')->user()->id)->where(function ($query) use ($request) {
            $query->whereBetween('form', [$request->from, $request->to])
                ->orWhereBetween('to', [$request->from, $request->to]);
        })->count();
        $leave="";
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

        $dateFrom = new DateTime($request->from);
        $dateTo = new DateTime($request->to);
        $interval = $dateFrom->diff($dateTo);
        $da = $interval->format('%a');
        $days = $da + 1;
        $firstMonthofDay =  Carbon::now()->startOfMonth()->toDateString(); //Current month Range
        $nextMonthFirstfDay =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(1)->toDateString(); //second month Range
        $nextToNextMonthFirstfDay =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2)->toDateString(); //last and 3 range month
        $lastMonthofDay = Carbon::now()->endOfMonth()->toDateString();
        // dd($lastMonthofDay,$nextMonthFirstfDay,$nextToNextMonthFirstfDay);

        $userLeave = Leave::where('user_id', Auth::guard('web')->user()->id)->latest()->first();
        // dd($userLeave->toArray());
        $leaveOfMOnth = monthleave::where('user_id', Auth::guard('web')->user()->id)->where('status', 1)->first();
        $leaveType = settingleave::find($request->type_id);
        // dd($userLeave,"enter");
        /*
        if ($leaveType->type == "Sick") {
            if ($userLeave->day <= $leaveOfMOnth->sickLeave) {  
                if ($request->from >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $request->to;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
                    $lastMonthofDayD = Carbon::now()->endOfMonth();
                    $diffDay = $dateFrom->diff($lastMonthofDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $lastMonthofDay;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        $lastMonthofDays = Carbon::now()->endOfMonth();
                        $fromNewDate = $lastMonthofDays->addDay(1);
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->from = $fromNewDate;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                } elseif ($request->from > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $request->to;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
                    $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                    $diffDay = $dateFrom->diff($nextToMonthLastDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $nextToMonthLastDayD;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        // dd("3 Month Record ");
                        $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $lastMonthofDays;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                }
            } else { //sick over day
                $newSickVsOther = $days- $leaveOfMOnth->sickLeave;
                $leaveMontDay= round( $leaveOfMOnth->sickLeave);
                $leaveMontDayother= round( $leaveOfMOnth->sickLeave);
                $leaveMontDay=$leaveMontDay-1;
                $newDayDeffOther= round($newSickVsOther);
                $newToDate = Carbon::createFromDate($request->from)->addDay($leaveMontDay)->toDateString();           
                $newFromDateOther = Carbon::createFromDate($request->from)->addDay($leaveMontDayother)->toDateString();     
                $newFromDateOtherNo = Carbon::createFromDate($request->from)->addDay($leaveMontDayother);     
             
            if ($leaveMontDayother>0) {               
                if ($request->from >= $firstMonthofDay && $newToDate <= $lastMonthofDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $newToDate;
                    $leaveRecord->day = $leaveMontDay+1;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from <= $lastMonthofDay && $newToDate >= $lastMonthofDay) {
                    $lastMonthofDayD = Carbon::now()->endOfMonth();
                    $diffDay = $dateFrom->diff($lastMonthofDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $lastMonthofDay;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        $lastMonthofDays = Carbon::now()->endOfMonth();
                        $fromNewDate = $lastMonthofDays->addDay(1);
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->from = $fromNewDate;
                        $leaveRecord->to = $newToDate;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                } elseif ($request->from > $lastMonthofDay && $newToDate < $nextToNextMonthFirstfDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $newToDate;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from >= $nextMonthFirstfDay && $newToDate >= $nextToNextMonthFirstfDay) {
                    $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                    $diffDay = $dateFrom->diff($nextToMonthLastDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $nextToMonthLastDayD;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        // dd("3 Month Record ");
                        $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $lastMonthofDays;
                        $leaveRecord->to = $newToDate;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                }
            }
            if ($newSickVsOther>0){
                $sess= Session::where('status',1)->first();
                $otherIdType= settingleave::where('type','Other')->where('status',1)->first('id');
                // dd($otherIdType->id);
                    if ($newFromDateOther >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
                        $lastMonthofDayD = Carbon::now()->endOfMonth();
                        $diffDay = $newFromDateOtherNo->diff($lastMonthofDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $newSickVsOther;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    } elseif ($newFromDateOther <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
                        $lastMonthofDayD = Carbon::now()->endOfMonth();
                        $diffDay = $newFromDateOtherNo->diff($lastMonthofDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $lastMonthofDay;
                        $leaveRecord->day = $daysn;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                        $NewRecord = $newSickVsOther - $daysn;
                        if ($NewRecord > 0) {
                            $lastMonthofDays = Carbon::now()->endOfMonth();
                            $fromNewDate = $lastMonthofDays->addDay(1);
                            $leaveRecord = new Leaverecord();
                            $leaveRecord->user_id = $userLeave->user_id;
                            $leaveRecord->leave_id = $userLeave->id;
                            $leaveRecord->type_id = $otherIdType->id;
                            $leaveRecord->from = $fromNewDate;
                            $leaveRecord->to = $request->to;
                            $leaveRecord->day = $NewRecord;
                            $leaveRecord->reason = $request->reason;
                            $leaveRecord->status = 2;
                            $leaveRecord->save();
                        }
                    } elseif ($newFromDateOther > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $days;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    } elseif ($newFromDateOther >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
                        $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                        $diffDay = $newFromDateOtherNo->diff($nextToMonthLastDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $nextToMonthLastDayD;
                        $leaveRecord->day = $daysn;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                        $NewRecord = $newSickVsOther - $daysn;
                        if ($NewRecord > 0) {
                            // dd("3 Month Record ");
                            $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                            $leaveRecord = new Leaverecord();
                            $leaveRecord->user_id = $userLeave->user_id;
                            $leaveRecord->type_id = $otherIdType->id;
                            $leaveRecord->leave_id = $userLeave->id;
                            $leaveRecord->from = $lastMonthofDays;
                            $leaveRecord->to = $request->to;
                            $leaveRecord->day = $NewRecord;
                            $leaveRecord->reason = $request->reason;
                            $leaveRecord->status = 2;
                            $leaveRecord->save();
                        }
                    }
                }
            }               
            
        } elseif ($leaveType->type == "Annual") {
            if ($userLeave->day <= $leaveOfMOnth->anualLeave) {  
                if ($request->from >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $request->to;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
                    $lastMonthofDayD = Carbon::now()->endOfMonth();
                    $diffDay = $dateFrom->diff($lastMonthofDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $lastMonthofDay;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        $lastMonthofDays = Carbon::now()->endOfMonth();
                        $fromNewDate = $lastMonthofDays->addDay(1);
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->from = $fromNewDate;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                } elseif ($request->from > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $request->to;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
                    $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                    $diffDay = $dateFrom->diff($nextToMonthLastDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $nextToMonthLastDayD;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        // dd("3 Month Record ");
                        $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $lastMonthofDays;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                }
            } else { //sick over day
                $newSickVsOther = $days- $leaveOfMOnth->anualLeave;
                $leaveMontDay= round( $leaveOfMOnth->anualLeave);
                $leaveMontDayother= round( $leaveOfMOnth->anualLeave);
                $leaveMontDay=$leaveMontDay-1;
                $newDayDeffOther= round($newSickVsOther);
                $newToDate = Carbon::createFromDate($request->from)->addDay($leaveMontDay)->toDateString();           
                $newFromDateOther = Carbon::createFromDate($request->from)->addDay($leaveMontDayother)->toDateString();     
                $newFromDateOtherNo = Carbon::createFromDate($request->from)->addDay($leaveMontDayother);     
              
            if ($leaveMontDayother>0) {               
                if ($request->from >= $firstMonthofDay && $newToDate <= $lastMonthofDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $newToDate;
                    $leaveRecord->day = $leaveMontDay+1;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from <= $lastMonthofDay && $newToDate >= $lastMonthofDay) {
                    $lastMonthofDayD = Carbon::now()->endOfMonth();
                    $diffDay = $dateFrom->diff($lastMonthofDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $lastMonthofDay;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        $lastMonthofDays = Carbon::now()->endOfMonth();
                        $fromNewDate = $lastMonthofDays->addDay(1);
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->from = $fromNewDate;
                        $leaveRecord->to = $newToDate;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                } elseif ($request->from > $lastMonthofDay && $newToDate < $nextToNextMonthFirstfDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $newToDate;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from >= $nextMonthFirstfDay && $newToDate >= $nextToNextMonthFirstfDay) {
                    $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                    $diffDay = $dateFrom->diff($nextToMonthLastDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $nextToMonthLastDayD;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        // dd("3 Month Record ");
                        $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $lastMonthofDays;
                        $leaveRecord->to = $newToDate;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                }
            }
            if ($newSickVsOther>0){
                $sess= Session::where('status',1)->first();
                $otherIdType= settingleave::where('type','Other')->where('status',1)->first('id');
                // dd($otherIdType->id);
                    if ($newFromDateOther >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
                        $lastMonthofDayD = Carbon::now()->endOfMonth();
                        $diffDay = $newFromDateOtherNo->diff($lastMonthofDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $newSickVsOther;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    } elseif ($newFromDateOther <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
                        $lastMonthofDayD = Carbon::now()->endOfMonth();
                        $diffDay = $newFromDateOtherNo->diff($lastMonthofDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $lastMonthofDay;
                        $leaveRecord->day = $daysn;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                        $NewRecord = $newSickVsOther - $daysn;
                        if ($NewRecord > 0) {
                            $lastMonthofDays = Carbon::now()->endOfMonth();
                            $fromNewDate = $lastMonthofDays->addDay(1);
                            $leaveRecord = new Leaverecord();
                            $leaveRecord->user_id = $userLeave->user_id;
                            $leaveRecord->leave_id = $userLeave->id;
                            $leaveRecord->type_id = $otherIdType->id;
                            $leaveRecord->from = $fromNewDate;
                            $leaveRecord->to = $request->to;
                            $leaveRecord->day = $NewRecord;
                            $leaveRecord->reason = $request->reason;
                            $leaveRecord->status = 2;
                            $leaveRecord->save();
                        }
                    } elseif ($newFromDateOther > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $days;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    } elseif ($newFromDateOther >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
                        $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                        $diffDay = $newFromDateOtherNo->diff($nextToMonthLastDayD);
                        $diffDay = $diffDay->format('%a');
                        $daysn = $diffDay + 1;
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $otherIdType->id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $newFromDateOther;
                        $leaveRecord->to = $nextToMonthLastDayD;
                        $leaveRecord->day = $daysn;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                        $NewRecord = $newSickVsOther - $daysn;
                        if ($NewRecord > 0) {
                            // dd("3 Month Record ");
                            $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                            $leaveRecord = new Leaverecord();
                            $leaveRecord->user_id = $userLeave->user_id;
                            $leaveRecord->type_id = $otherIdType->id;
                            $leaveRecord->leave_id = $userLeave->id;
                            $leaveRecord->from = $lastMonthofDays;
                            $leaveRecord->to = $request->to;
                            $leaveRecord->day = $NewRecord;
                            $leaveRecord->reason = $request->reason;
                            $leaveRecord->status = 2;
                            $leaveRecord->save();
                        }
                    }
                }
            }        
        }else{//other Date And Month Wise Save            
                if ($request->from >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $request->to;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
                    $lastMonthofDayD = Carbon::now()->endOfMonth();
                    $diffDay = $dateFrom->diff($lastMonthofDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $lastMonthofDay;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        $lastMonthofDays = Carbon::now()->endOfMonth();
                        $fromNewDate = $lastMonthofDays->addDay(1);
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->from = $fromNewDate;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                } elseif ($request->from > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $request->to;
                    $leaveRecord->day = $days;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                } elseif ($request->from >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
                    $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
                    $diffDay = $dateFrom->diff($nextToMonthLastDayD);
                    $diffDay = $diffDay->format('%a');
                    $daysn = $diffDay + 1;
                    $leaveRecord = new Leaverecord();
                    $leaveRecord->user_id = $userLeave->user_id;
                    $leaveRecord->type_id = $userLeave->leaves_id;
                    $leaveRecord->leave_id = $userLeave->id;
                    $leaveRecord->from = $request->from;
                    $leaveRecord->to = $nextToMonthLastDayD;
                    $leaveRecord->day = $daysn;
                    $leaveRecord->reason = $request->reason;
                    $leaveRecord->status = 2;
                    $leaveRecord->save();
                    $NewRecord = $days - $daysn;
                    if ($NewRecord > 0) {
                        $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                        $leaveRecord = new Leaverecord();
                        $leaveRecord->user_id = $userLeave->user_id;
                        $leaveRecord->type_id = $userLeave->leaves_id;
                        $leaveRecord->leave_id = $userLeave->id;
                        $leaveRecord->from = $lastMonthofDays;
                        $leaveRecord->to = $request->to;
                        $leaveRecord->day = $NewRecord;
                        $leaveRecord->reason = $request->reason;
                        $leaveRecord->status = 2;
                        $leaveRecord->save();
                    }
                }
        }
        */
        if ($request->from >= $firstMonthofDay && $request->to <= $lastMonthofDay) {
            $leaveRecord = new Leaverecord();
            $leaveRecord->user_id = $userLeave->user_id;
            $leaveRecord->type_id = $userLeave->leaves_id;
            $leaveRecord->leave_id = $userLeave->id;
            $leaveRecord->from = $request->from;
            $leaveRecord->to = $request->to;
            $leaveRecord->day = $days;
            $leaveRecord->reason = $request->reason;
            $leaveRecord->status = 2;
            $leaveRecord->save();
        } elseif ($request->from <= $lastMonthofDay && $request->to >= $lastMonthofDay) {
            $lastMonthofDayD = Carbon::now()->endOfMonth();
            $diffDay = $dateFrom->diff($lastMonthofDayD);
            $diffDay = $diffDay->format('%a');
            $daysn = $diffDay + 1;
            $leaveRecord = new Leaverecord();
            $leaveRecord->user_id = $userLeave->user_id;
            $leaveRecord->leave_id = $userLeave->id;
            $leaveRecord->type_id = $userLeave->leaves_id;
            $leaveRecord->from = $request->from;
            $leaveRecord->to = $lastMonthofDay;
            $leaveRecord->day = $daysn;
            $leaveRecord->reason = $request->reason;
            $leaveRecord->status = 2;
            $leaveRecord->save();
            $NewRecord = $days - $daysn;
            if ($NewRecord > 0) {
                $lastMonthofDays = Carbon::now()->endOfMonth();
                $fromNewDate = $lastMonthofDays->addDay(1);
                $leaveRecord = new Leaverecord();
                $leaveRecord->user_id = $userLeave->user_id;
                $leaveRecord->leave_id = $userLeave->id;
                $leaveRecord->type_id = $userLeave->leaves_id;
                $leaveRecord->from = $fromNewDate;
                $leaveRecord->to = $request->to;
                $leaveRecord->day = $NewRecord;
                $leaveRecord->reason = $request->reason;
                $leaveRecord->status = 2;
                $leaveRecord->save();
            }
        } elseif ($request->from > $lastMonthofDay && $request->to < $nextToNextMonthFirstfDay) {
            $leaveRecord = new Leaverecord();
            $leaveRecord->user_id = $userLeave->user_id;
            $leaveRecord->leave_id = $userLeave->id;
            $leaveRecord->type_id = $userLeave->leaves_id;
            $leaveRecord->from = $request->from;
            $leaveRecord->to = $request->to;
            $leaveRecord->day = $days;
            $leaveRecord->reason = $request->reason;
            $leaveRecord->status = 2;
            $leaveRecord->save();
        } elseif ($request->from >= $nextMonthFirstfDay && $request->to >= $nextToNextMonthFirstfDay) {
            $nextToMonthLastDayD =  Carbon::now()->endOfMonth()->addMonthsNoOverflow(1); //last and 3 range month
            $diffDay = $dateFrom->diff($nextToMonthLastDayD);
            $diffDay = $diffDay->format('%a');
            $daysn = $diffDay + 1;
            $leaveRecord = new Leaverecord();
            $leaveRecord->user_id = $userLeave->user_id;
            $leaveRecord->type_id = $userLeave->leaves_id;
            $leaveRecord->leave_id = $userLeave->id;
            $leaveRecord->from = $request->from;
            $leaveRecord->to = $nextToMonthLastDayD;
            $leaveRecord->day = $daysn;
            $leaveRecord->reason = $request->reason;
            $leaveRecord->status = 2;
            $leaveRecord->save();
            $NewRecord = $days - $daysn;
            if ($NewRecord > 0) {
                $lastMonthofDays = $nextToNextMonthFirstfDayD =  Carbon::now()->startOfMonth()->addMonthsNoOverflow(2); //last and 3 range month
                $leaveRecord = new Leaverecord();
                $leaveRecord->user_id = $userLeave->user_id;
                $leaveRecord->type_id = $userLeave->leaves_id;
                $leaveRecord->leave_id = $userLeave->id;
                $leaveRecord->from = $lastMonthofDays;
                $leaveRecord->to = $request->to;
                $leaveRecord->day = $NewRecord;
                $leaveRecord->reason = $request->reason;
                $leaveRecord->status = 2;
                $leaveRecord->save();
            }
        }
        return redirect()->route('employees.leave');
    }


    // --------------delete function-----------------------
    public function delete($id)
    {
        // dd("dele");
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

    // ----------------------------admin leave function-----------------------------

}
