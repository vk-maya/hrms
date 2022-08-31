<?php

namespace App\Models;

use App\Models\Leave\Leave;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'in_time', 'out_time', 'work_time', 'date', 'day', 'month', 'year', 'attendance', 'status', 'passdate', 'mark'];

    public function userinfo(){
        return $this->hasOne(User::class);
    }
    public function wfh(){
        return $this->hasOne(WorkFromHome::class,'user_id','user_id');
    }

    public function leavestatus(){
        return $this->hasOne(Leave::class,'user_id','user_id');
    }
    public function userinfoatt(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
