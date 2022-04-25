<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientModel extends Model
{
    use HasFactory, SoftDeletes;

    
    public function projectclient(){
        return $this->hasMany(ProjectModel::class);
    }
}
