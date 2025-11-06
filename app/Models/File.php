<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'mime',
        'extension',
        'path',
        'size',
        'type',
        'user_id',
    ];

    protected function casts()
    {
        return [
            'user_id' => 'integer',
            'size' => 'integer',
        ];
    }

    public function user() : belongsTo {
        return $this->belongsTo(User::class);
    }
}
