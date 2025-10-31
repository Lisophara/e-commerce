<?php

namespace App\Models;

use App\Sluggable;
use Illuminate\Database\Eloquent\Model;

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
}
