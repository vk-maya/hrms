<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSalary extends Model
{
    use HasFactory;
    public function usersget(){
        return $this->belongsTo(User::class,'user_id')->where('status',1);
    }
}
