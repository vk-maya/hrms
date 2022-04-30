<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function task_followers(){
        return $this->belongsToMany(User::class,'task_followers','task_id','team_id');
    }
}
