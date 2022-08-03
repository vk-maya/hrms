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
use App\Models\monthleave;

class AdminLeaveController extends Controller
{
    public function edit($id)
    {
        $data = Leave::find($id);
        $type = settingleave::all();

        return view('admin.leave.edit-leave', compact('data', 'type'));
    }

    public function update(Request $request){
        $data = Leave::find($request->id);
        $leavetype = settingleave::where('id', $request->type)->count();
        if ($leavetype > 0){
            $data->leaves_id = $request->type;
        } else{
            return back()->withErrors(["type_id" => "Please Select Leave Type"])->withInput();
        }
        $date = now();
        $fromdate = date("Y-m-d", strtotime("$date + 30 day"));
        if ($request->from <= $fromdate){
            $data->form = date('Y-m-d', strtotime($request->from));
            $todate = date("Y-m-d", strtotime("$request->from + 30 day"));
            if ($request->to <= $todate) {
                $data->to = date('Y-m-d', strtotime($request->to));
            } else {
                return redirect()->back()->withErrors(["to" => "Please Select to Date Type"])->withInput();;
            }
        }else{
            return redirect()->back()->withErrors(["from" => "Please Select Leave Type"])->withInput();;
        }
        $leave = Leave::where('user_id', $request->user_id)->where(function ($query) use ($request) {
            $query->where('form', '<=', $request->from)->where('to', '>=', $request->from);
        })->orWhere(function ($query) use ($request) {
            $query->where('form', '<=', $request->to)->where('to', '>=', $request->to);
        })->where('id', "!=", $request->id)->count();
        if ($leave > 0){
            return back()->withErrors(["from" => "Please Select another From date"])->withInput();
        }
        $data->reason = $request->reason;
        $data->save();
        return redirect()->route('admin.leave.list');
    }
    public function holidays(Request $request)
    {
        if ($request->id != ''){
            $holi = Holiday::find($request->id);
            $data = Holiday::all();
            return view('admin.leave.holiday', compact('holi', 'data'));
        } else {
            $data = Holiday::all();
            return view('admin.leave.holiday', compact('data'));
        }
    }
    public function delete($id){
        // dd("dele");
        $data = Leave::find($id);
        if ($data->status == 1) {
            return back()->with(["unsuccess" => "Don't Delete This Record"])->withInput();
        } else {
            $leaverecord = Leaverecord::where('leave_id',$id)->get();
            foreach ($leaverecord as $record) {
               $record->delete();
            }
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
        // dd($request->toArray());
        $data = Leave::find($request->id);
    //   dd($data->status);
       
        $leaverall = Leaverecord::where("leave_id", $request->id)->get();
     
        
        if ($request->status == 1 && $data->status != $request->status ) {
            // dd("appr");
            foreach ($leaverall as $value) {
                $setl = settingleave::find($value->type_id);
                $totaleave = UserleaveYear::where('user_id',$data->user_id)->first();
                // dd($totaleave);
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
            $data->status = $request->status;
            $data->update();
                $leaverecord = Leaverecord::where('leave_id',$request->id)->get();
                    foreach ($leaverecord as $key => $record) {
                        $record->status= $request->status;
                        $record->save();
                    }
        }elseif($data->status == 1 && ($request->status == 0 || $request->status == 2)){
            foreach ($leaverall as $key => $value) {
                $setl = settingleave::find($value->type_id);
                $totaleave = UserleaveYear::where('user_id',$data->user_id)->first();
                if ($setl->id == $value->type_id && $setl->type == 'Annual') {                  
                        $tt = $totaleave->netAnual;
                        $totaleave->netAnual = $tt - $value->day;                 
                } elseif ($setl->id == $value->type_id && $setl->type == 'Sick') {
                  
                        $tt = $totaleave->netSick;
                        $totaleave->netSick = $tt - $value->day;
                   
                
                } elseif ($setl->id == $value->type_id && $setl->type == 'Other') {
                  
                        $tt = $totaleave->other;
                        $totaleave->other = $tt - $value->day;
                   
                }
                  $totaleave->save();
            }
            $data->status = $request->status;
                $data->update();
            $leaverecord = Leaverecord::where('leave_id',$request->id)->get();
                foreach ($leaverecord as $key => $record) {
                    $record->status= $request->status;
                    $record->save();
                }     
            }else{
                
                $data->status = $request->status;
                $data->update();
                $leaverecord = Leaverecord::where('leave_id',$request->id)->get();
                    foreach ($leaverecord as $key => $record) {
                        $record->status= $request->status;
                        $record->save();
                    }    
            }        
        return redirect()->back();




    /*public function monthleave(){
        $session= Session::where('status',1)->latest()->first();
        $users = User::where('status', 1)->get();
        $yearleave=settingleave::where('status',1)->get();
        foreach ($yearleave as $key => $value) {
           if ($value->type=="Annual") {
            $anual =$value->day/12;
           }elseif($value->type=="Sick"){
            $sickl = $value->day/12;
        }
    }
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
            }
            $data= new monthleave();
            $data->user_id=$user->id;
                        $from=date('Y-m-d',strtotime($jd));
                        $to =date('Y-m-d',strtotime($end));
            $data->from= $from;
            $data->to=$to;
                        $anual=$diffr*$anual;         
                        $sick=$diffr*$sickl;
            $data->anualLeave=$anual;
            $data->sickLeave=$sick;
            $data->status=1;
            $data->save();
            
            
        }
        return redirect()->back();
    }*/
    }
    public function moreleave($id){
        $data = Leaverecord::where('leave_id',$id)->with('leavetype')->get();
        // dd($data->toArray());
        return view('admin.leave.leaverecord',compact('data'));
    }
}
