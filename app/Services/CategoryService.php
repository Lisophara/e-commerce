<?php

namespace App\Services;

use App\Models\Category;
use App\Utils;

final class CategoryService
{
    private function __construct(){ /** no object */ }

    public static function getCategories() {
        return Utils::cache('product.categories', fn () => Category::all());
    }

    public static function getCategoriesForSelect() {
        return self::getCategories()->pluck(function ($category) {
            return empty($category->label) ? $category->name : $category->label;
        }, 'id');
    }
}
