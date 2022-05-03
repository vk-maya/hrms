<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class projectLeader extends Model
{
    use HasFactory , SoftDeletes;

    public function user(){

        return $this->belongsTo(User::class,"leader_id");

    }
}