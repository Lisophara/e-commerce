<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class Utils
{
    private function __construct() { /** no obj */}

    public static function removeFiles($files, $driver = 'public') {
        try {
            if (is_array($files)) {
                foreach ($files as $file) {
                    $file = Storage::disk($driver)->path($file);
                    if (file_exists($file) && is_file($file)) {
                        unlink($file);
                    }
                }
            } else {
                $files = Storage::disk($driver)->path($files);
                if (file_exists($files) && is_file($files)) {
                    unlink($files);
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public static function putCache($key, $value, $ttl = null) : void {
        Cache::put($key, $value, $ttl ?? env('CACHE_TTL', 300));
    }

    public static function getCache($key, $default = null) {
        return Cache::get($key, $default);
    }

    public static function hasCache($key): bool {
        return Cache::has($key);
    }
}
