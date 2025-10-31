<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'description',
    ];

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function files() : BelongsToMany {
        return $this->belongsToMany(File::class);
    }
}
