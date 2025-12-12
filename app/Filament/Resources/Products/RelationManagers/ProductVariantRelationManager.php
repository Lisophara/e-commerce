<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Filament\ComponentHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductVariantRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    /**
     * @return string|null
     */
    public static function getModelLabel(): ?string
    {
        return __('product.variant');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('color')
                    ->label(__('messages.color'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('quantity')
                    ->label(__('messages.quantity'))
                    ->integer()
                    ->default(-1),
                ComponentHelper::fileUpload('image')
                    ->label(__('messages.image'))
                    ->columnSpanFull(),
                Section::make(__('messages.size'))
                    ->schema([
                    ComponentHelper::repeater('sizes', [
                        TextInput::make('size')
                            ->label(__('messages.size'))
                            ->required(),
                        TextInput::make('quantity')
                            ->integer()
                            ->default(-1),
                    ])
                        ->default(null)
                        ->label(__('messages.size') . __('messages.product'))
                        ->columnSpanFull()
                ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Variant')
            ->columns([
                ComponentHelper::renderImage('image')
                    ->label(__('messages.image')),
                TextColumn::make('color')
                    ->label(__('messages.color'))
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label(__('messages.quantity')),
                TextColumn::make('sizes')
                    ->label(__('messages.size'))
                    ->badge()
                    ->getStateUsing(function ($record) {
                        return array_slice(array_map(function ($row) {
                            return $row['size'];
                        }, $record->sizes), 0, 4);
                    })
                    ->color('gray')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('product.create.variant'))
                    ->before(function ($data) {
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading(__('product.variant.empty'))
            ->emptyStateDescription('');
    }
}
