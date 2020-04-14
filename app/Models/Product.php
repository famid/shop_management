<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable=['name','shop_id','subcategory_id','category_id'];

    /**
     * @return BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function subcategory() {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * @return BelongsTo
     */
    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    /**
     * @return HasMany
     */
    public function productVariations() {
        return $this->hasMany(ProductVariation::class);
    }
}
