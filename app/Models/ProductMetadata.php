<?php

namespace App\Models;

use App\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductMetadata extends Model
{
    use Sluggable;
    protected $fillable = [
        'product_id',
        'label',
        'label_slug',
        'group_slug',
        'type'
    ];

    protected function sluggable(): array
    {
        return [
            'label'
        ];
    }

    public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function metadata() : HasMany {
        return $this->hasMany(ProductMetadata::class, 'group_slug', 'group_slug');
    }
}
