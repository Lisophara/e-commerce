<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    protected $fillable = [
        'name',
        'mime',
        'extension',
        'path',
        'size',
        'type',
        'checksum_sha256',
        'user_id',
        'is_success_uploaded',
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
