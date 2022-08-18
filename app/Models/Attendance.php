<?php

namespace App\Models;

use App\Models\Leave\Leave;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'in_time', 'out_time', 'work_time', 'date', 'day', 'month', 'year', 'attendance', 'status', 'passdate'];

    public function userinfo(){
        return $this->hasOne(User::class);
    }
    public function wfh(){
        return $this->hasOne(WorkFromHome::class,'date','date');
    }
    public function leaveStatus(){
        return $this->hasOne(Leave::class,'form','date');
    }
}
