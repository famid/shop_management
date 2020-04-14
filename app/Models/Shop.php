<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    protected $fillable = ['name','size','location','user_id'];

    /**
     * @return HasMany
     */
    public function products () {
        return $this->hasMany(Product::class);
    }

    /**
     * @return HasMany
     */
    public function employees () {
        return $this->hasMany(Employee::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
