<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leave\Leave;
use Illuminate\Http\Request;
use App\Models\Leave\settingleave;
use App\Http\Controllers\Controller;
use App\Models\Holiday;

class AdminLeaveController extends Controller
{
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
        $rules = [
            'day' => ['required', 'string'],   
            
        ];
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
