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

    public function taskDetails(){
        return $this->hasOne(Task::class, 'id','task_id');
    }

    public function projectDetails(){
        return $this->hasOne(ProjectModel::class,'id','project_id');
    }
    public function taskreport(){
        return $this->hasMany(taskstatus::class,'task_id','task_id');
    }
    
    
}
