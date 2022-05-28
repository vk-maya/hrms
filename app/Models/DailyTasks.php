<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTasks extends Model
{
    use HasFactory;

    public $table = 'daily_tasks';
public function limitdate(){
    return $this->hasMany(user::class,'id','user_id');
}
}
