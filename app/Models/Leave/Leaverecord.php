<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaverecord extends Model
{
    use HasFactory;

    public function leavetype(){
       return $this->hasOne(settingleave::class,'id','type_id');
    }
}
