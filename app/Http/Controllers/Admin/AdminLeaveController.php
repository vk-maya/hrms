<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Leave\Leave;
use Illuminate\Http\Request;
use App\Models\Admin\Session;
use App\Models\Leave\settingleave;
use App\Models\Admin\UserleaveYear;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LeaveController;
use App\Models\Leave\Leaverecord;

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
            if ($request->to <= $todate) {
                $data->to = date('Y-m-d', strtotime($request->to));
            } else {
                return redirect()->back()->withErrors(["to" => "Please Select to Date Type"])->withInput();;
            }
        } else {
            return redirect()->back()->withErrors(["from" => "Please Select Leave Type"])->withInput();;
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
    public function delete($id)
    {
        $data = Leave::find($id);
        if ($data->status != null) {
            return back()->with(["unsuccess" => "Don't Delete This Record"])->withInput();
        } else {
            $data->delete();
            return back()->with(["success" => "Success Delete This Record"])->withInput();
        }
    }
    public function holidayStore(Request $request)
    {
        $rules = [
            'name' => ['required', 'string'],
            'date' => ['required', 'date'],

        ];
        if ($request->id != "") {
            // dd($request->toArray());
            $data = Holiday::find($request->id);
        } else {
            $data = new Holiday();
        }
        $request->validate($rules);
        $data->holidayName = $request->name;
        $data->date = $request->date;
        $data->status = 1;
        $data->save();
        return redirect()->route('admin.holidays');
    }
    public function holidaydistroy($id)
    {
        $data = Holiday::find($id)->delete();
        return redirect()->back();
    }

    public function leavesetting()
    {
        return view('admin.leave.leave-setting');
    }
    public function leavelist()
    {
        $data = Leave::with('user')->latest()->get();
        return view('admin.leave.leave', compact('data'));
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
    public function leavereport(Request $request)
    {
        $data = Leave::find($request->id);
        $data->status = $request->status;
        $leaverall = Leaverecord::where("leave_id", $request->id)->get();
        if ($request->status == 1) {
            foreach ($leaverall as $key => $value) {
                $setl = settingleave::find($value->type_id);
                $totaleave = UserleaveYear::where('user_id', Auth::guard('web')->user()->id)->latest()->first();
                if ($setl->id == $value->type_id && $setl->type == 'Annual') {
                    if ($totaleave->netAnual != null) {
                        $tt = $totaleave->netAnual;
                        $totaleave->netAnual = $tt + $value->day;
                    } else {
                        $totaleave->netAnual = $value->day;
                    }
                } elseif ($setl->id == $value->type_id && $setl->type == 'Sick') {
                    if ($totaleave->netSick != null) {
                        $tt = $totaleave->netSick;
                        $totaleave->netSick = $tt + $value->day;
                    } else {
                        $totaleave->netSick =  $value->day;
                    }
                } elseif ($setl->id == $value->type_id && $setl->type == 'Other') {
                    if ($totaleave->other != null) {
                        $tt = $totaleave->other;
                        $totaleave->other = $tt + $value->day;
                    } else {
                        $totaleave->other = $value->day;
                    }
                }
                $totaleave->save();
            }
            $data->update();
        }
        return redirect()->back();
    }
    public function monthleave()
    {
        // dd("hello");
        $session= Session::where('status',1)->latest()->first();
        // dd($session->toArray());
        $users = User::where('status', 1)->get();
        $yearleave=settingleave::where('status',1)->get();
        dd($yearleave->toArray());
        foreach ($users as $key => $user) {
            $jd = $user->joiningDate;
            $str = date('Y-m',strtotime($jd));
            $strr = $str."-15";
            if ($jd>$session->from) {
                if ($jd<$strr){
                    $jd=date('Y-m',strtotime($jd));
                    $jd= $jd."-01";
                    dd($jd);                    
                }else{
                $jd=Carbon::parse($jd)->addMonths();
                $jd=date('Y-m',strtotime($jd));
                $jd = $jd."-01";         
                    }
            $end = now();
            $end=date('Y-m',strtotime($end));
            $end=Carbon::parse($end)->endOfMonth();
            $end=date('Y-m-d',strtotime($end));
                $diffr = round(Carbon::parse($jd)->floatDiffInMonths($end));
                dd($diffr);
                $jd=$session->from;
                dd($jd);             
            }
            

        }
    }
}
