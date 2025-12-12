<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'title',
        'remark',
        'description',
        'store_id',
        'code',
        'price',
        'quantity',
        'images',
        'published',
        'created_by',
    ];

    protected function casts() : array
    {
        return [
            'store_id' => 'int',
            'price' => 'real',
            'quantity' => 'integer',
            'images' => 'array',
        ];
    }

     public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
     }

     public function categories() : BelongsToMany {
        return $this->belongsToMany(Category::class, 'product_categories');
     }

     public function reviews() : HasMany {
        return $this->hasMany(ProductReview::class);
     }

     public function productRatings() : HasMany {
        return $this->hasMany(ProductReview::class);
     }

     public function discount(): HasOne {
        return $this->hasOne(DiscountProduct::class)
            ->whereActive()
            ->whereActiveRange();
     }

     public function variants() : HasMany
     {
         return $this->hasMany(ProductVariant::class);
     }
}
