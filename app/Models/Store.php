<?php

namespace App\Models;

use App\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Symfony\Component\HttpKernel\Profiler\Profile;

class Store extends Model
{
    use Sluggable;
    protected $fillable = [
        'name',
        'name_slug',
        'address',
        'contact',
        'user_id',
        'profile',
        'cover',
        'fb_link',
        'ig_link',
        'tlg_link',
        'twitter_link',
    ];

    protected function casts() : array
    {
        return [
            'user_id' => 'integer',
        ];
    }

    protected function sluggable(): array
    {
        return [
            'name',
        ];
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function profile(): HasOne {
        return $this->hasOne(File::class);
    }

    public function cover(): HasOne {
        return $this->hasOne(File::class);
    }

    public function storeRatings(): HasMany {
        return $this->hasMany(StoreRating::class);
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
}
