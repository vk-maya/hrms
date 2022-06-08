<?php

namespace App\Models\Leave;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;
    public function leaveType(){
        return $this->hasOne(settingleave::class,'id','leaves_id');
    }
public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    // public function leavetype(){

    // }
}
