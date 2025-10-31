<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductRating extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
    ];

    protected function casts() : array
    {
        return [
            'rating' => 'integer',
            'user_id' => 'integer',
            'product_id' => 'integer',
        ];
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
