<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['shop_id','name','still_working','salary','started_at','ended_at'];
}
