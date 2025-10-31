<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreRating extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'rating',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'store_id' => 'integer',
            'rating' => 'integer',
        ];
    }

    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
