<?php

namespace App\Models;

use App\Models\Designation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'country_id',
        'last_name',
        'email',
        'password',
        'employee_id',
        'joining_date',
        'phone',
        'department_id',
        'designation_id',
        'address',
        'city',
        'state',
        'status',
        'workplace',
        'image',
        'image',
    ];
    public function designation()    {
        return $this->belongsTo(Designation::class);
    }
    public function leaders()
    {
        // return $this->belongsTo(ProjectLeaders::class);
        return $this->hasMany(ProjectLeaders::class,"leader_id");
    }
    public function team()
    {
        return $this->hasMany(ProjectTeams::class,"team_id");
    }
    public function dailyTask(){
        return $this->hasMany(DailyTasks::class,"user_id");
    }
    public function department(){
        return $this->hasOne(Department::class,'id','department_id');
    }
    public function profiledesignation(){
        return $this->hasOne(Designation::class,'id','designation_id');
    }
    public function moreinfo(){
        return $this->hasOne(userinfo::class,'user_id');
    }

    public function attendence()
    {
        return $this->hasMany(Attendance::class, 'user_id', 'employeeID');
    }
  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
