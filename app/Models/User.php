<?php

namespace App\Models;

use App\Models\Admin\SalaryEarenDeduction;
use App\Models\Admin\SalaryManagment;
use App\Models\Admin\Session;
use App\Models\Admin\UserEarndeducation;
use App\Models\Admin\UserSalary;
use App\Models\Designation;
use App\Models\Leave\Leave;
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
        'first_name',
        'country_id',
        'last_name',
        'email',
        'password',
        'employee_id',
        'joiningDate',
        'phone',
        'department_id',
        'designation_id',
        'address',
        'city',
        'state',
        'status',
        'workplace',
        'image',
    ];

    public function monthleave(){
        return $this->hasOne(monthleave::class,'user_id','id')->where('status', 1);
    }

    public function monthleavelist(){
        return $this->hasOne(monthleave::class,'user_id','id');
    }

    public function leave(){
        return $this->hasMany(Leave::class,'user_id','id');
    }

    public function designation()    {
        return $this->belongsTo(Designation::class);
    }

    public function userDesignation()    {
        return $this->belongsTo(Designation::class,'designation_id');
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

    public function usersalary(){
        return $this->hasOne(usersalary::class,'user_id')->where('status', 1);
    }


// })->count();
    //  $attendance= Attendance::where('user_id',Auth::guard('web')->user()->machineID)->where(function($query)use($first_date,$last_date){
    // $query->whereBetween('date',[$first_date,$last_date]);})->get();



    public function attendence()
    {

        return $this->hasMany(Attendance::class);
    }
    public function attendance(){
        return $this->hasOne(Attendance::class,'user_id','machineID');
    }
    public function salary(){
        return $this->hasOne(UserSalary::class,'user_id');
    }

    public function userSalaryData()
    {
        return $this->belongsToMany(SalaryManagment::class,'user_earndeducations','user_id','salary_earndeductionID');
    }

    public function userSalarySystem()
    {
        return $this->hasManyThrough(SalaryEarenDeduction::class, UserEarndeducation::class, 'user_id', 'salaryM_id', 'id', 'salary_earndeductionID');
    }
    public function usersalaryget(){
        return $this->hasMany(UserSalary::class);
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
