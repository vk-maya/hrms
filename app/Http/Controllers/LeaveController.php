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
        $data = Leave::where('user_id',Auth::guard('web')->user()->id)->with('leaveType')->latest()->get();
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
        $data->status = "";
        $data->save();
        return redirect()->route('employees.leave');
    }
    // ----------------------------admin leave function-----------------------------
    public function leavesetting(){
        return view('admin.leave.leave-setting');
    }
    public function leavelist(){
        $data = Leave::with('user')->latest()->get();
        // dd($data->toArray());
        return view('admin.leave.leave',compact('data'));
    }
    public function leavetype(Request $request){
        $data = new settingleave();
        $data->type =$request->type;
        $data->day =$request->day;
        $data->status="";
        $data->save();
        return redirect()->back();
    }
    public function leavereport(Request $request){
        // dd($request->toArray());
        $data = Leave::find($request->id);
        $data->status = ($request->status != 'null') ? $request->status : '';
        $data->update();
        return redirect()->back();  
    }
}
