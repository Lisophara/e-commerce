<?php

namespace App;

use AnourValar\EloquentSerialize\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Sluggable
{
    public static function bootSluggable() {
        function convert_slug($array, $options) : array{
            foreach ($options as $key => $value) {
                if (is_int($key)) {
                    if (array_key_exists($value, $array)) {
                        $array[$value . '_slug'] = Str::slug($array[$value]);
                    }
                } elseif (array_key_exists($key, $array)) {
                    $array[$value] = Str::slug($array[$key]);
                }
            }
            return $array;
        }
        static::creating(function (Model $model) {
            $slugs = convert_slug($model->toArray(), $model->sluggable());
            if (!empty($slugs)) {
                foreach ($slugs as $key => $slug) {
                    $model->{$key} = $slug;
                }
            }
        });
    }

    protected function sluggable() : array {
        return [];
    }
}
