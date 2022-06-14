<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leave\Leave;
use Illuminate\Http\Request;
use App\Models\Leave\settingleave;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LeaveController;
use App\Models\Admin\Session;
use App\Models\Holiday;

class AdminLeaveController extends Controller
{
    public function edit($id){
        $data = Leave::find($id);
        $type = settingleave::all();

        return view('admin.leave.edit-leave',compact('data','type'));
    }

    public function update(Request $request){
        $data = Leave::find($request->id);      
        $leavetype = settingleave::where('id',$request->type)->count();
            if($leavetype>0){
                $data->leaves_id =$request->type;
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
                return redirect()->back()->withErrors(["to" => "Please Select to Date Type"])->withInput(); ;
            }
        }else{
            return redirect()->back()->withErrors(["from" => "Please Select Leave Type"])->withInput(); ;
        }
        $leave = Leave::where('user_id',$request->user_id)->where(function($query) use($request){
            $query->where('form','<=',$request->from)->where('to','>=',$request->from);
        })->orWhere(function($query) use($request){
            $query->where('form','<=',$request->to)->where('to','>=',$request->to);
        })->where('id',"!=", $request->id)->count();
        if($leave > 0){
            return back()->withErrors(["from" => "Please Select another From date"])->withInput();
        }
        $data->reason = $request->reason;
        $data->save();
        return redirect()->route('admin.leave.list');

    }
    public function holidays(Request $request){
        if($request->id!=''){
            $holi = Holiday::find($request->id);
            $data = Holiday::all();
            return view('admin.leave.holiday',compact('holi','data'));
        }else{
            $data = Holiday::all();
            return view('admin.leave.holiday',compact('data'));
            
        }
    }
    public function delete($id){
        $data = Leave::find($id);
        if($data->status != null){
            return back()->with(["unsuccess" => "Don't Delete This Record"])->withInput(); 
        }else{
            $data->delete();
            return back()->with(["success" => "Success Delete This Record"])->withInput();        }
    }
    public function holidayStore(Request $request){
        $rules = [
            'name' => ['required', 'string'],   
            'date' => ['required', 'date'],
            
        ];
        if($request->id != ""){
            // dd($request->toArray());
            $data = Holiday::find($request->id);

        }else{
            $data = new Holiday();
        }
        $request->validate($rules);
        $data->holidayName = $request->name;
        $data->date = $request->date;
        $data->status =1;
        $data->save();
        return redirect()->route('admin.holidays');

    }
    public function holidaydistroy($id){
        $data = Holiday::find($id)->delete();
        return redirect()->back();

    }

    public function leavesetting(){
        return view('admin.leave.leave-setting');
    }
    public function leavelist(){
        $data = Leave::with('user')->latest()->get();
        return view('admin.leave.leave',compact('data'));
    }
    public function leavetype(Request $request){
        $type = settingleave::where('type',$request->type)->get();
      
        $rules = [
            'day' => ['required', 'string'],   
            
        ];
        $dd = now('y-m-d');
                dd($dd->toArray());

        // $session = Session::where('from',)
        $request->validate($rules);
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
