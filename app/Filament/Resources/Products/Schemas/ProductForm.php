<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\ComponentHelper;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\UserServices;
use App\Utils;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        $stores = UserServices::getCurrentUserStore()->pluck('name', 'id');
        return $schema
            ->components([
                Section::make(__('messages.details'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('product.title'))
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('code')
                            ->label(__('product.code'))
                            ->maxLength(64),
                        TextInput::make('quantity')
                            ->label(__('messages.quantity'))
                            ->numeric()
                            ->required(),
                        ComponentHelper::numeric('price')
                            ->label(__('messages.price'))
                            ->required(),
                        Select::make('store_id')
                            ->label(__('messages.store'))
                            ->required()
                            ->searchable()
                            ->options($stores)
                            ->default($stores->keys()->first()),
                        CheckBox::make('published')
                            ->extraFieldWrapperAttributes([
                                'style' => 'margin-top: auto; margin-bottom: auto;'
                            ])
                            ->label(__('messages.published')),
                        ComponentHelper::richEditor('remark')
                            ->label(__('messages.remark')),
                        ComponentHelper::richEditor('description')
                            ->label(__('messages.description'))
                    ])
                    ->columns()
                    ->columnSpan(2),
                Group::make()->schema([
                    Section::make(__('messages.category'))
                        ->schema([
                            Select::make('categories')
                                ->label(__('messages.category'))
                                ->relationship('categories', 'name')
                                ->options(CategoryService::getCategoriesForSelect())
                                ->multiple()
                                ->searchable()
                                ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->columns(1)
                            ->columnSpan(1),
                    Section::make(__('messages.image'))
                        ->schema([
                            ComponentHelper::fileUpload('images')
                                ->label(__('messages.image'))
                                ->multiple()
                                ->acceptedFileTypes(
                                    [
                                        'image/png',
                                        'image/jpg',
                                        'image/jpeg',
                                        'video/mp4'
                                    ]
                                )
                                ->reorderable()
                                ->required(),
                        ])
                        ->collapsible()
                        ->columns(1)
                        ->columnSpan(1)
                ]),
            ])->columns(3);
    }
}
