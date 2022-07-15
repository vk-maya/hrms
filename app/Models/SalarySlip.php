<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    use HasFactory;
    protected $fillable =[
        'id',
        'employee_id','basic_salary','tds','da','est','hra','pf','conveyance','Prof_tax',
        'allowance','Labour_welf','Medical_allow','other'
    ];
    public function user()
    {
        return $this->belongsTo(User::class ,'employee_id' ,'id');
    }
}
