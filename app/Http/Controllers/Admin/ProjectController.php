<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
        public function index(){

            return view('admin.project.project');

        }
        
        public function create(){
            return view('admin.project.add-project');
        }
}
