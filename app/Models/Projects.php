<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'projects';

    public function client()
    {
        return $this->belongsTo(Clients::class);
    }

    public function team(){

        return $this->belongsToMany(User::class,'project_team_models','prject_id','team_id');

    }

    public function leaders(){

        return $this->belongsToMany(User::class,'project_leaders','prject_id','leader_id');

    }

    public function image(){
        return $this->hasMany(ProjectImage::class,'prject_id');
    }

    public function employees(){
        return $this->belongsTo(User::class);
    }

    public function TaskBoard(){
        return $this->hasMany(TaskBoards::class,'project_id');
    }

    public function Tasks(){
        return $this->hasMany(Task::class,'project_id');
    }
}
