<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;
    public function salaryManagementWithDeduct()
    {
        $this->belongsToMany(SalaryManagment::class,'salary_earen_deductions','session_id','session_id');
    }
}
