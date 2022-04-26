<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =[
        'designation_name',
        'department_id',
        'status'
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
}
  
