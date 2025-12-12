<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'color',
        'sizes',
        'quantity',
        'image'
    ];

    protected function casts()
    {
        return [
            'sizes' => 'array',
            'quantity' => 'integer',
        ];
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }
}
