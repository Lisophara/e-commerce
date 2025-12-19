<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('username')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('order_items_sum_quantity')
                    ->label(__('messages.quantity'))
                    ->sum('orderItems', 'quantity'),
                TextColumn::make('order_items_sum_price')
                    ->label(__('messages.price'))
                    ->sum('orderItems', 'price'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
    }
}
