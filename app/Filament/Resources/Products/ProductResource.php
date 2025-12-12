<?php

namespace App\Filament\Resources\Products;

use App\Enum\UserType;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\RelationManagers\ProductVariantRelationManager;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::InboxStack;

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('messages.group.product');
    }

    public static function getModelLabel(): string
    {
        return __('messages.product');
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return __('messages.product');
    }

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ProductVariantRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

//    public static function canAccess(): bool
//    {
//        return auth()->check() && in_array(auth()->getUser()->type, [UserType::ADMIN, UserType::MERCHANT]);
//    }
}
