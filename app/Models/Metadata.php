<?php

namespace App\Models;

use App\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Metadata extends Model
{
    use Sluggable;
    protected $table = 'metadata';

    protected $fillable = [
        'store_id',
        'name',
        'name_slug',
        'group',
        'group_slug',
    ];

    public function sluggable() : array {
        return [
            'name',
            'group',
        ];
    }

    public function store() : BelongsTo {
        return $this->belongsTo(Store::class);
    }

}
