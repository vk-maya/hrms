<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyTasks;
use App\Models\Clients;
use App\Models\ProjectImage;
use App\Models\ProjectLeaders;
use App\Models\Projects;
use App\Models\ProjectTeams;
use App\Models\Task;
use App\Models\TaskBoards;
use App\Models\TaskFollowers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    public function index(){
            $project = Projects::with('team', 'leaders')->get();
        return view('admin.project.project', compact('project'));
    }

    public function view($id){

        $project = Projects::with('team', 'leaders', 'image')->find($id);

        return view('admin.project.project-view', compact('project'));
    }


    public function list(){
        $leader = ProjectLeaders::with('user')->get();
        $team = ProjectTeams::with('user')->get();
        $projectlist = Projects::all();
        return view('admin.project.project', compact('projectlist', 'leader', 'team'));
    }

    public function create($id = ""){
        if ($id > 0) {
            $employeesc = User::all();
            $client = Clients::all();
            $project = Projects::with('team', 'leaders', 'image')->find($id);
            return view('admin.project.add-project', compact('project', 'client', 'employeesc'));
        } else {

            $employeesc = User::all();
            $client = Clients::all();
            return view('admin.project.add-project', compact('client', 'employeesc'));
        }
    }
    public function edit(Request $request){
    }
    public function store(Request $request){
        // dd($request->toArray());
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'clientname' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'max:255'],
            'end_date' => ['required', 'max:255'],
            'rate' => ['required',],
            'duration' => ['required',],
            'priority' => ['required',],
            'description' => ['required',],
            'teamlead' => ['required',],
            'team' => ['required',],
            'image' => ['required'],
            'status' => ['required'],
        ];
        if ($request->id == !null) {
            $project = Projects::find($request->id);
        } else {
            $project = new Projects();
        }
        $request->validate($rules);
        $project->name = $request->name;
        $project->auth_id = $request->project_create;
        $project->client_id = $request->clientname;
        $project->start_date = date('Y-m-d', strtotime($request->start_date));
        $project->end_date = date('Y-m-d', strtotime($request->end_date));
        $project->rate = $request->rate;
        $project->duration = $request->duration;
        $project->priority = $request->priority;
        $project->description = $request->description;
        $project->status = 1;
        $project->save();
        $project_id = Projects::latest()->first();
        foreach ($request->teamlead as $item) {
            $teamleader = new ProjectLeaders();
            $teamleader->leader_id = $item;
            $teamleader->prject_id = $project_id->id;
            $teamleader->status = 1;
            $teamleader->save();
        }
        foreach ($request->team as $item) {
            $team = new ProjectTeams();
            $team->prject_id = $project_id->id;
            $team->team_id = $item;
            $team->status = 1;
            $team->save();
        }
        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach ($files as $file) {
                $fname = $file->getClientOriginalExtension();
                $newfilename = "client" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $fname;
                $file->storeAs('public/project', $newfilename);
                $fileimg = new ProjectImage;
                $fileimg->prject_id = $project_id->id;
                $fileimg->image = $newfilename;
                $fileimg->status = 1;
                $fileimg->save();
            }
        }
        return redirect()->route('admin.project');
    }
    public function update(Request $request){
        $project = Projects::find($request->id);
        $project->name = $request->name;
        $project->auth_id = $request->project_create;
        $project->client_id = $request->clientname;
        $project->start_date = date('Y-m-d', strtotime($request->start_date));
        $project->end_date = date('Y-m-d', strtotime($request->end_date));
        $project->rate = $request->rate;
        $project->duration = $request->duration;
        $project->priority = $request->priority;
        $project->description = $request->description;
        $project->status = ($request->status == 1) ? 1 : 0;
        $project->update();
        $project_id = $request->id;
        if ($request->teamlead == !null) {
            foreach ($request->teamlead as $item) {
                $check = ProjectLeaders::where('prject_id',$project_id)->where('leader_id',$item)->first();
                if($check == null) {
                         $team = new ProjectLeaders();
                         $team->prject_id = $project_id;
                         $team->leader_id = $item;
                         $team->save();
                     }

            }
        }
        if ($request->team == !null) {
            foreach ($request->team as $item) {
                $check = ProjectTeams::where('prject_id',$project_id)->where('team_id',$item)->first();
                if($check == null){
                         $team = new ProjectTeams();
                         $team->prject_id = $project_id;
                         $team->team_id = $item;
                         $team->save();
                     }

             }
        }
        if ($request->image == !null) {
            if ($request->hasFile('image')) {
                $files = $request->file('image');
                foreach ($files as $file) {
                    $fname = $file->getClientOriginalExtension();
                    $newfilename = "client" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $fname;
                    $file->storeAs('public/project', $newfilename);
                    $fileimg = new ProjectImage;
                    $fileimg->prject_id = $project_id;
                    $fileimg->image = $newfilename;
                    $fileimg->save();
                    }
                }
            }
        return redirect()->route('admin.project');
    }

    public function filedelete($id){
        ProjectImage::find($id)->delete();
        return response()->json(['msg' => 'yes']);
    }

    public function delete($id){
        Projects::find($id)->delete();
        $delete = ProjectImage::where('prject_id', $id);
        foreach ($delete as $key => $value) {
            storage::delete('public/project/' . $value->image);
        }
        ProjectImage::where('prject_id', $id)->delete();
        ProjectTeams::where('prject_id', $id)->delete();
        ProjectLeaders::where('prject_id', $id)->delete();
        return response()->json(['msg' => 'yes']);
    }
    public function team_member_delete(Request $request){
        // dd($request->toArray());
      ProjectTeams::where('prject_id',$request->pid)->where('team_id',$request->id)->delete();

        return response()->json(['msg' => 'yes']);
    }
    // ---------------------task--------------------------------
    public function task($id){
        $employees = User::all();
        $project = Projects::with('team', 'leaders', 'image','Tasks','TaskBoard')->find($id);
        return view('admin.project.task-board', compact('project','employees'));
    }
    public function task_board_create(Request $request){
        $rules=[
            'name'=>['required'],
            'tbcolor' => ['required'],
        ];
        $request->validate($rules);
        $data  = new TaskBoards();
        $data->name =$request->name;
        $data->project_id =$request->project_id;
        $data->tbcolor =$request->tbcolor;
        $data->status = ($request->status == 1) ? 1 : 0;
        $data->save();
        return redirect()->back();
    }
    public function task_create($id ,$tbid){
        $project = Projects::with('team', 'leaders', 'image','Tasks')->find($id);
        $tb_id = $tbid;
        return view('admin.project.add-task',compact('project','tb_id'));
    }
    public function task_store(Request $request){
        // dd($request->toArray());
        $id = $request->project_id;
        $rule = [
                'name' =>['required'],
                'priority' =>['required'],
                'start_date' =>['required'],
                'due_date' =>['required'],
                'team' =>['required'],
        ];
        $request->validate($rule);
        $data = new Task();
        $data->name = $request->name;
        $data->assigned_id = $request->assigned_id;
        $data->project_id = $request->project_id;
        $data->tb_id = $request->tb_id;
        $data->priority = $request->priority;
        $data->start_date = $request->start_date;
        $data->end_date = $request->due_date;
        $data->status = ($request->status == 1) ? 1 : 0;
        $data->save();
        $task = Task::latest()->first();
        $task_id = $task->id;
        foreach ($request->team as $key => $value) {
            $data = new TaskFollowers();
            $data->task_id =$task_id;
            $data->project_id = $request->project_id;
            $data->team_id = $value;
            $data->status= 1;
            $data->save();
        }

        return redirect()->route('admin.project.task.board', compact('id'));

    }
    public function taskboardelete($id){
        $data = Task::where('tb_id',$id)->count();
        if($data>0){
            return response()->json(['msg' => 'no']);
        }else{
            TaskBoards::find($id)->delete();
            return response()->json(['msg' => 'yes']);
        }

    }
    public function taskdelete($id){
        // dd($id);
        Task::find($id)->delete();
        $data =TaskFollowers::where('task_id',$id)->get();
        foreach ($data as $key => $value) {
            TaskFollowers::find($value->id)->delete();
        }
        return response()->json(['msg' => 'yes']);

        }

    public function dailytask(){
        return view('admin.project.dailytask');
    }
    public function dailystore(Request $request){
        dd($request->toArray());
        $request->validate([
            'name'=> 'required',
        ]);
        $data = new DailyTasks();
        $data->user_id = $request->id;
        $data->name = $request->name;
        $data->status = 0;
        $data->check = "admin";
        $data->save();
    }
    public function showtask(){
        $dailytask = DailyTasks::all();
        return response()->json(['data' => $dailytask]);
    }
    public function alltask(){        
        $employees  = User::with('dailyTask')->get();
        // dd($employees);
        return view('admin.task.all-task-list',compact('employees'));

    }
    public function employeestask($id){
        $data = DailyTasks::where('user_id',$id)->latest()->get();
        return view('admin.task.emplo-task-list',compact('data'));
    }
    public function empltask($id){
        // dd($id);
        $data = DailyTasks::find($id);
        return view('admin.task.task-view-emp',compact('data'));

        }
    }
