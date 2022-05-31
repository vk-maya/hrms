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
        $data = new Leave();
        $data->user_id =$request->user_id;
        $data->leaves_id =$request->type_id;
        $data->form = date('Y-m-d', strtotime($request->from));
        $data->to = date('Y-m-d', strtotime($request->to));
        $data->reason = $request->reason;
        $data->status = "";
        $data->save();
        return redirect()->route('employees.leave');
    }
    // ----------------------------admin leave function-----------------------------
    
}
