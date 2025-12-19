<?php

namespace App\Filament\Resources\Products\Tables;

use App\Enum\UserType;
use App\Filament\ComponentHelper;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\UserServices;
use App\Utils;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
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
                        return array_map(function ($category) {
                            return empty($category['label']) ? $category['name'] : $category['label'];
                        }, $record->{$column->getName()}->slice(0, 4)->toArray());
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
                SelectFilter::make('store_id')
                    ->label(__('messages.store'))
                    ->searchable()
                    ->multiple()
                    ->options(UserServices::getCurrentUserStore()->pluck('name', 'id')),
                SelectFilter::make('categories')
                    ->label(__('messages.category'))
                    ->options(CategoryService::getCategoriesForSelect())
                    ->searchable(),
                TernaryFilter::make('published')
                    ->label(__('messages.published')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->recordUrl(null)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->emptyStateHeading(__('product.empty'))
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->type !== UserType::ADMIN) {
                    $query->whereIn('store_id', UserServices::getCurrentUserStore()->pluck('id'));
                }
            });
    }
}
