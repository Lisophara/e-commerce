<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Utils;
use Illuminate\Support\Collection;

final class ProductService
{
    private function __construct() { /** No object */}

    public static function getProductById(int $id): Product {
        return Utils::cache('product.' . $id, function () use ($id) {
            return Product::with('variants')->find($id);
        });
    }

    public static function getProducts()
    {
        return Utils::cache('products', function () {
            return Product::all();
        });
    }

    public static function getProductVariantsByProductId(int $id) : Collection {
        return Utils::cache('product.' . $id . '.variants', function () use ($id) {
            return ProductVariant::where('product_id', $id)->all();
        });
    }

    public static function getProductVariantById(int $id) : ProductVariant {
        return Utils::cache('product.' . $id . '.variant', function () use ($id) {
            return ProductVariant::find($id);
        });
    }
}
