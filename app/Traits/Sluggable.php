<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable() : void {
        static::creating(function (Model $model) {
            $slugs = self::convertSlug($model->toArray(), $model->sluggable());
            if (!empty($slugs)) {
                foreach ($slugs as $key => $slug) {
                    $model->{$key} = $slug;
                }
            }
        });
    }

    static function convertSlug($array, $options) : array {
        foreach ($options as $key => $value) {
            if (is_int($key)) {
                if (array_key_exists($value, $array) && !empty($array[$value])) {
                    $array[$value . '_slug'] = Str::slug($array[$value]);
                }
            } elseif (array_key_exists($key, $array) && !empty($array[$key])) {
                $array[$value] = Str::slug($array[$key]);
            }
        }
        return $array;
    }

    protected function sluggable() : array {
        return [];
    }
}
