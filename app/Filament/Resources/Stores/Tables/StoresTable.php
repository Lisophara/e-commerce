<?php

namespace App\Filament\Resources\Stores\Tables;

use App\Filament\ComponentHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StoresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ComponentHelper::renderImage('profile')
                    ->label(__('messages.profile')),
                ComponentHelper::renderImage('cover')
                    ->label(__('messages.cover')),
                TextColumn::make('name')
                    ->label(__('store.name'))
                    ->searchable(),
                TextColumn::make('user')
                    ->label(__('store.username'))
                    ->formatStateUsing(function ($record) {
                        return $record->user->first_name . ' ' . $record->user->last_name;
                    })
                    ->searchable(),
                TextColumn::make('contact')
                    ->label(__('messages.contact'))
                    ->copyable()
                    ->searchable(),
                TextColumn::make('fb_link')
                    ->label(__('store.facebook') ?? 'Facebook')
                    ->url(fn ($record) => $record->fb_link, true)
                    ->limit(15)
                    ->searchable(),
                TextColumn::make('ig_link')
                    ->label(__('store.instagram') ?? 'Instagram')
                    ->url(fn ($record) => $record->ig_link, true)
                    ->limit(15)
                    ->searchable(),
                TextColumn::make('tlg_link')
                    ->label(__('store.telegram') ?? 'Telegram')
                    ->url(fn ($record) => $record->tlg_link, true)
                    ->limit(15)
                    ->searchable(),
                TextColumn::make('twitter_link')
                    ->label(__('store.twitter') ?? 'Twitter')
                    ->url(fn ($record) => $record->twitter_link, true)
                    ->limit(15)
                    ->searchable(),
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
            ]);
    }
}
