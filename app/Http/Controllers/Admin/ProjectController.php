<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientModel;
use App\Models\ProjectImage;
use App\Models\projectLeader;
use App\Models\ProjectModel;
use App\Models\ProjectTeamModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    public function index()
    {
        // $leader = projectLeader::with('user')->get();
        // $team = ProjectTeamModel::with('user')->get();
        $project = ProjectModel::with('team', 'leaders')->get();
        // dd($project->toarray());       
        return view('admin.project.project', compact('project'));
    }
    public function view($id)
    {

        $project = ProjectModel::with('team', 'leaders', 'image','auth')->find($id);
// dd($project->toArray());

        return view('admin.project.project-view', compact('project'));
    }
    public function list()
    {
        $leader = projectLeader::with('user')->get();
        $team = ProjectTeamModel::with('user')->get();
        $projectlist = ProjectModel::all();
        return view('admin.project.project', compact('projectlist', 'leader', 'team'));
    }

    public function create($id = "")
    {
        if ($id > 0) {
            $employeesc = User::all();
            $client = ClientModel::all();
            $project = ProjectModel::with('team', 'leaders', 'image')->find($id);
            return view('admin.project.add-project', compact('project', 'client', 'employeesc'));
        } else {

            $employeesc = User::all();
            $client = ClientModel::all();
            return view('admin.project.add-project', compact('client', 'employeesc'));
        }
    }
    public function edit(Request $request)
    {
    }
    public function store(Request $request)
    {
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
            $project = ProjectModel::find($request->id);
        } else {
            $project = new ProjectModel();
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
        $project->status = ($request->status == 1) ? 1 : 0;
        $project->save();
        $project_id = ProjectModel::latest()->first();
        foreach ($request->teamlead as $item) {
            $teamleader = new projectLeader();
            $teamleader->leader_id = $item;
            $teamleader->prject_id = $project_id->id;
            $teamleader->save();
        }
        foreach ($request->team as $item) {
            $team = new ProjectTeamModel();
            $team->prject_id = $project_id->id;
            $team->team_id = $item;
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
                $fileimg->save();
            }
        }
        return redirect()->route('admin.project');
    }
    public function update(Request $request)
    {
        // dd($request->toArray());
        $project = ProjectModel::find($request->id);
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
                $check = projectLeader::where('prject_id',$project_id)->where('leader_id',$item)->first();
                if($check == null)
                {
                         $team = new projectLeader();
                         $team->prject_id = $project_id;
                         $team->leader_id = $item;
                         $team->save();
                     }

        }
      
    }
        if ($request->team == !null) {
            foreach ($request->team as $item) {
                $check = ProjectTeamModel::where('prject_id',$project_id)->where('team_id',$item)->first();
                if($check == null)
                {
                         $team = new ProjectTeamModel();
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
    public function filedelete($id)
    {
        ProjectImage::find($id)->delete();
        return response()->json(['msg' => 'yes']);
    }
    public function delete($id)
    {
        ProjectModel::find($id)->delete();
        $delete = ProjectImage::where('prject_id', $id);
        foreach ($delete as $key => $value) {
            storage::delete('public/project/' . $value->image);
        }
        ProjectImage::where('prject_id', $id)->delete();
        ProjectTeamModel::where('prject_id', $id)->delete();
        projectLeader::where('prject_id', $id)->delete();
        return response()->json(['msg' => 'yes']);
    }
}
