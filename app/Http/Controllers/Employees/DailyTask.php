<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Models\DailyTasks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DailyTask extends Controller
{
 public function dailytask (){
     $date = now();
     $task = DailyTasks::where('user_id',Auth::guard('web')->user()->id)->whereDate('post_date', date('Y-m-d', strtotime($date)))->count();
    if($task<2){
        $limit = DailyTasks::where('post_date',date('Y-m-d', strtotime($date)))->count();

    }else{
        return redirect()->back();
    }

    return view('employees.dailytask');
 }
 public function showtaskk($id){
     $task = DailyTasks::find($id);
     if($task->user_id==Auth::guard('web')->user()->id){
         $dalilydata = DailyTasks::find($id);
         return view('employees.task-view',compact('dalilydata'));
     }else{
         return redirect()->back();
     }
}
public function dailystore(Request $request){
    // dd($request->toArray());
    $request->validate([
        'description'=> 'required',
        'title'=> 'required',
    ]);
    $data = new DailyTasks();
    $data->user_id =$request->user_id;
    $data->description = $request->description;
    $data->title = $request->title;
    $data->post_date = date('Y-m-d', strtotime($request->post_date));
    $data->status =1;
    $data->check = "emp";
    $data->save();
    return redirect()->route('dashboard');
}
public function tasklist(){
    $data = DailyTasks::where('user_id', Auth::guard('web')->user()->id)->latest()->get();
    return view('employees.task-list', compact('data'));
        }
}
