<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'username',
        'address',
        'additional'
    ];

    protected function casts(): array
    {
        return [
            'additional' => 'json',
        ];
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function orderItems() : HasMany {
        return $this->hasMany(ProductOrder::class);
    }
}
