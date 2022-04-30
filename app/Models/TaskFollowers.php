<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFollowers extends Model
{
    use HasFactory;

    public function taskDetail(){
        return $this->belongsTo(Task::class,'task_id');
    }
    public function projectDetail(){
        return $this->belongsTo(ProjectModel::class,'project_id');
    }
}
