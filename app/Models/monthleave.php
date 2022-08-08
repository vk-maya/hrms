<?php

namespace App\Models;

use App\Models\Leave\Leave;
use App\Models\Leave\Leaverecord;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class monthleave extends Model
{
    use HasFactory;
    public function leave(){
        return $this->hasMany(Leave::class,'user_id','user_id')->where('1')->with('leaverecord');
    }
    // public function leaverecord(){
    //     return $this->hasMany(Leaverecord::class,)
    // }
}
