<?php

namespace App\Http\Controllers;

use App\Models\Leave\Leave;
use Illuminate\Http\Request;
use App\Models\Leave\settingleave;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
//    ------------------------employees function ----------------------
    public function leave(){
        $data = Leave::where('user_id',Auth::guard('web')->user()->id)->with('leaveType')->get();
        return view('employees.leave.leave',compact('data'));
    }
    public function leaveadd(){
        $data = settingleave::all();
    
        return view('employees.leave.add-leave',compact('data'));
    }
    public function storeleave(Request $request){
        $data = new Leave();
        $data->user_id =$request->user_id;
        $data->leaves_id =$request->type_id;
        $data->form =date('Y-m-d', strtotime($request->from));
        $data->to = date('Y-m-d', strtotime($request->to));
        $data->reason = $request->reason;
        $data->status = 1;
        $data->save();
        return redirect()->route('employees.leave');
    }
    // ----------------------------admin leave function-----------------------------
    public function leavesetting(){
        return view('admin.leave.leave-setting');
    }
    public function leavelist(){
        $data = Leave::all();
        return view('admin.leave.leave',compact('data'));
    }
    public function leavetype(Request $request){
        $data = new settingleave();
        $data->type =$request->type;
        $data->day =$request->day;
        $data->status=1;
        $data->save();
        return redirect()->back();


    }
}
