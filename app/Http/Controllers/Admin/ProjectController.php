<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientModel;
use App\Models\projectLeader;
use App\Models\ProjectModel;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
        public function index(){
            $project = ProjectModel::all();
            return view('admin.project.project',compact('project'));
        }
        
        public function create(){
            $employeesc =User::all();
            $client = ClientModel::all();
            return view('admin.project.add-project', compact('client','employeesc'));
        }
        public function store(Request $request)
        {
           
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'clientname' => ['required', 'string', 'max:255'],
                'start_date' => ['required','max:255'],
                'end_date' => ['required', 'max:255'],
                'rate' => ['required',],
                'duration' => ['required', ],
                'priority' => ['required',],
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
            // dd($request->toArray());
            $request->validate($rules);
            $project->name = $request->name;
            $project->client_id = $request->clientname;
            $project->start_date =date('Y-m-d', strtotime($request->start_date));
            $project->end_date = date('Y-m-d', strtotime($request->end_date));
            $project->rate = $request->rate;
            $project->duration = $request->duration;
            $project->priority = $request->priority;
            $project->teamlead = $request->teamlead;
            // $project->teamlead =implode(',', $request->teamlead);  
            $project->team =implode(',', $request->team);                           
            $project->status = ($request->status == 1) ? 1 : 0;
            $project->save();
            $project_id = ProjectModel::latest()->first();             
                $teamleader = new projectLeader();
                foreach ($request->teamlead as $item) {
                    $teamleader->leader_id = $item;
                    $teamleader->prject_id = $project_id;
                    $teamleader->save();
                }
            if ($request->hasFile('image') == 1) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = "client" . str_replace(' ', '', $request->name) . rand(0, 10000) . "." . $ext;
                $file = $request->file('image')->storeAs('public/project', $filename);
                $project->image = $filename;
            }              
             
                return redirect()->route('admin.project');
        }
}
