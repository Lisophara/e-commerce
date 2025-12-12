<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\ComponentHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Html;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ComponentHelper::renderImage('images')
                    ->label(__('messages.image'))
                    ->limit(1),
                TextColumn::make('code')
                    ->label(__('product.code'))
                    ->tooltip(function ($record) {
                        return new HtmlString($record->remark);
                    })
                    ->copyable()
                    ->searchable(),
                TextColumn::make('store.name')
                    ->label(__('messages.store')),
                ComponentHelper::renderCurrency('price')
                    ->label(__('messages.price')),
                TextColumn::make('quantity')
                    ->label(__('messages.quantity')),
                TextColumn::make('categories')
                    ->label(__('messages.category'))
                    ->badge()
                    ->getStateUsing(function ($record, $column) {
                        return array_slice(array_map(function ($category) {
                            return empty($category['label']) ? $category['name'] : $category['label'];
                        }, $record->{$column->getName()}->toArray()), 0, 4);
                    })
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('messages.description'))
                    ->limit()
                    ->html(),
                ToggleColumn::make('published')
                    ->disabled()
                    ->label(__('messages.published'))
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->recordUrl(null)
            ->toolbarActions([
                BulkActionGroup::make([
//                    DeleteBulkAction::make(),
                ]),
            ])->emptyStateHeading(__('product.empty'));
    }
}
