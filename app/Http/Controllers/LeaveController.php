<?php

namespace App\Http\Controllers;

use App\Models\Leave\Leave;
use Illuminate\Http\Request;
use App\Models\Leave\settingleave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;


class LeaveController extends Controller
{
//    ------------------------employees function ----------------------

    public function leave(){
        $data = Leave::where('user_id',Auth::guard('web')->user()->id)->with('leaveType')->latest()->get();
        return view('employees.leave.leave',compact('data'));
    }
    public function leaveadd(){
        $data = settingleave::all();
        return view('employees.leave.add-leave',compact('data'));
    }
    public function storeleave(Request $request){
        // dd($request->from);
        $rules = [
            'type_id' => ['required', 'integer'],
            'from' => ['required', 'date'],   
            'to' => ['required', 'date'],   
            'reason' => ['required', 'string'],
        ];
        $date = date('Y-m-d', strtotime($request->from)) ;
        $nowdate =date('Y-m-d', strtotime(now()));
        if($date<=$nowdate){
            return back()->withErrors(["from" => "Please Select From date"])->withInput();
        }
        if( date('Y-m-d', strtotime($request->to)) < $date){
            return back()->withErrors(["to" => "Please Select to date"])->withInput();
        }
        $request->validate($rules);
        // dd($leave->toArray());
        $data = new Leave();
        $data->user_id =Auth::guard('web')->user()->id;
        $leavetype = settingleave::where('id',$request->type_id)->count();
            if($leavetype>0){
                $data->leaves_id =$request->type_id;
            }else{
                return back()->withErrors(["type_id" => "Please Select Leave Type"])->withInput();            }
        $date = now();
        $fromdate=date( "Y-m-d",strtotime("$date + 30 day"));
        if($request->from <=$fromdate){
            $data->form = date('Y-m-d', strtotime($request->from));
            $todate = date( "Y-m-d",strtotime("$request->from + 30 day"));
            if($request->to <=$todate){
                $data->to = date('Y-m-d', strtotime($request->to));
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
        $leave = Leave::where('user_id',Auth::guard('web')->user()->id)->where(function($query) use($request){
            $query->where('form','<=',$request->from)->where('to','>=',$request->from);
        })->orWhere(function($query) use($request){
            $query->where('form','<=',$request->to)->where('to','>=',$request->to);
        })->count();
        if($leave > 0){
            return back()->withErrors(["from" => "Please Select another From date"])->withInput();
        }
        $data->reason = $request->reason;
        $data->status = "";
        $data->save();
        return redirect()->route('employees.leave');
        Carbon::createFromTime()->diff()->h
        // now()->toTimeString()
    }
    // ----------------------------admin leave function-----------------------------
    
}
