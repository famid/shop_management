<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Catagory extends Model
{
    protected $fillable = ['catagory_name'];

    /**
     * @return HasMany
     */
    public function subCatagories() {
        return $this->hasMany(SubCatagory::class);
    }

    /**
     * @return HasMany
     */
    public function products() {
        return $this->hasMany(Product::class);
    }
}
