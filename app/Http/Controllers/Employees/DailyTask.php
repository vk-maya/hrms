<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Models\DailyTaskModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DailyTask extends Controller
{
 public function dailytask (){

    return view('employees.dailytask');
 }
 public function showtaskk(){
    $dailytask = DailyTaskModel::where('team_id', Auth::guard('web')->user()->id)->get();
    return json_encode(array('data' => $dailytask));
}
public function dailystore(Request $request){
    // dd($request->toArray());
    $request->validate([
        'name'=> 'required',
        'title'=> 'required',
    ]);
    $data = new DailyTaskModel();
    $data->team_id = $request->id;
    $data->name = $request->name;
    $data->title = $request->title;
    $data->status =1;
    $data->check = "emp";
    $data->save();
    return redirect()->route('dashboard');
}
public function tasklist(){
    $data = DailyTaskModel::where('team_id', Auth::guard('web')->user()->id)->get();
    return view('employees.task-list', compact('data'));
        }
}
