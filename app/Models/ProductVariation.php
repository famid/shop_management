<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariation extends Model
{
    protected $fillable=['quantity','price','status','product_id'];

    /**
     * @return BelongsTo
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
