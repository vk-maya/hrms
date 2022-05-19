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
        return $this->belongsTo(Projects::class,'project_id');
    }

    public function taskDetails(){
        return $this->hasOne(Task::class, 'id','task_id');
    }

    public function projectDetails(){
        return $this->hasOne(Projects::class,'id','project_id');
    }
    public function taskreport(){
        return $this->hasMany(TaskStatus::class,'task_id','task_id');
    }


}
