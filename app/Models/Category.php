<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use Sluggable;
    protected $fillable = [
        'name',
        'name_slug',
        'label',
        'label_slug',
    ];

    protected function sluggable(): array
    {
        return [
            'name',
            'label',
        ];
    }

    public function products() : BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
