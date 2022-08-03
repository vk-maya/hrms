<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'in_time', 'out_time', 'work_time', 'date', 'day', 'month', 'year', 'attendance', 'status'];

    public function userinfo(){
        return $this->hasOne(User::class);
    }
}
