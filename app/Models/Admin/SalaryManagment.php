<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryManagment extends Model
{
    use HasFactory;
    
    public function earnDed()
    {
        $this->hasMany(SalaryEarenDeduction::class,'salary_earndeductionID');
    }

}
