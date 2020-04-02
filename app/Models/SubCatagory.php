<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubCatagory extends Model
{
    protected $fillable=['subcatagory_name','catagory_id'];

    /**
     * @return BelongsTo
     */
    public function catagory() {
        return $this->belongsTo(Catagory::class);
    }

    /**
     * @return HasMany
     */
    public function products() {
        return $this->hasMany(Product::class);
    }
}
