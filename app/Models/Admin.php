<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];
    public function autht()
    {
        return $this->hasMany(ProjectModel::class, 'auth_id');
    }
    function assigned()
    {
        return $this->hasOne(ProjectModel::class, 'assigned_id');
    }
}
