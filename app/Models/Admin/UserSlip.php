<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSlip extends Model
{
    use HasFactory;
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
