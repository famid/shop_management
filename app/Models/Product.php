<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable=['product_name','subcatagory_name','catagory_id'];

    /**
     * @return BelongsTo
     */
    public function catagory() {
        return $this->belongsTo(Catagory::class);
    }

    /**
     * @return BelongsTo
     */
    public function subcatagory() {
        return $this->belongsTo(SubCatagory::class);
    }

    /**
     * @return HasMany
     */
    public function productVariations() {
        return $this->hasMany(ProductVariation::class);
    }
}
