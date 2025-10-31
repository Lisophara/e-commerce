<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'store_id',
        'code',
        'price',
        'stock',
    ];

    protected function casts() : array
    {
        return [
            'store_id' => 'int',
            'price' => 'real',
            'stock' => 'integer',
        ];
    }

     public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
     }

     public function categories() : BelongsToMany {
        return $this->belongsToMany(Category::class);
     }

     public function reviews() : HasMany {
        return $this->hasMany(ProductReview::class);
     }

     public function productRatings() : HasMany {
        return $this->hasMany(ProductReview::class);
     }
}
