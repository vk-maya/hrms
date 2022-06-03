<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    public function userinfo(){
        return $this->hasOne(User::class, 'employeeID','user_id');
        }
}
