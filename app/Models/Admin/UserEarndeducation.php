<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class UserEarndeducation extends Model
{
    use HasFactory;
    public function salaryEarningDeduction(){
        return $this->hasOne(SalaryEarenDeduction::class,'id','salary_earndeductionID')->with('salarymanagement');
    }
   
}
