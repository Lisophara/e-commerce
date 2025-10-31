<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'product_metadata',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'product_metadata' => 'json',
            'quantity' => 'integer',
        ];
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
