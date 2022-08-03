<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryEarenDeduction extends Model
{
    use HasFactory;

    public function salarymanagement(){
        return $this->belongsTo(SalaryManagment::class,'salaryM_id','id');
    }
    public function session(){
        return $this->belongsTo(Session::class,'session_id','id');
    }
    public function salarymanag(){
        return $this->hasOne(SalaryManagment::class,'id','salaryM_id');
    }

}
