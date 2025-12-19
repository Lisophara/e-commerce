<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Filament\ComponentHelper;
use App\Services\ProductService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
//                        Select::make('user_id')
//                            ->label(__('messages.custom'))
//                            ->options(UserServices::getUserByType(UserType::CUSTOMER)->pluck('name', 'id'))
//                            ->searchable(),
                        TextInput::make('username')
                            ->autocomplete()
                            ->autofocus()
                            ->required(),
                        TextInput::make('address'),
                        ComponentHelper::repeater('product_info', [
                            Select::make('product_id')
                                ->label(__('messages.product'))
                                ->options(function () {
                                    return ProductService::getProducts()->pluck('title', 'id')->toArray();
                                })
                                ->reactive()
                                ->afterStateUpdated(function ($set, $get, $state) {
                                    if ($state !== null) {
                                        $product  = ProductService::getProductById($state);
                                        $set('variants', $product->variants);
                                        $set('color.options', $product->variants->pluck('color', 'id')->toArray());
                                    } else {
                                        $set('color.options', null);
                                    }
                                })
                                ->afterStateHydrated(function ($set, $get, $state) {
                                    if ($state !== null) {
                                        $product  = ProductService::getProductById($state);
                                        $set('variants', $product->variants);
                                        $set('color.options', $product->variants->pluck('color', 'id')->toArray());
                                    }
                                })
                                ->required(),
                            Select::make('product_variants.color')
                                ->label(__('messages.color'))
                                ->reactive()
                                ->options(function ($get) {
                                    return $get('color.options') ?? [];
                                })
                                ->visible(function ($get) {
                                    return !empty($get('color.options'));
                                })
                                ->afterStateHydrated(function ($set, $get, $state) {
                                    if ($state !== null) {
                                        $set('size.options',
                                            collect($get('variants')->where('id', $state)->first()->sizes)
                                                ->pluck('size', 'size')->toArray());
                                    }
                                })
                                ->afterStateUpdated(function ($set, $get, $state) {
                                    if ($state !== null) {
                                        $set('size.options', collect($get('variants')->where('id', $state)->first()->sizes)
                                            ->pluck('size', 'size')->toArray());
                                    } else {
                                        $set('size.options', null);
                                    }
                                }),
                            Select::make('product_variants.size')
                                ->label(__('messages.size'))
                                ->options(function ($get) {
                                    return $get('size.options') ?? [];
                                })
                                ->visible(function ($get) {
                                    return !empty($get('size.options'));
                                }),
                            ComponentHelper::numeric('quantity')
                                ->label(__('messages.quantity'))
                                ->live(true, '1s')
                                ->default(1),
                        ])
                        ->relationship('orderItems')
                        ->mutateRelationshipDataBeforeCreateUsing(function ($data) {
                            $product  = ProductService::getProductById($data['product_id']);
                            $data['price'] = $product->price * $data['quantity'];
                            return $data;
                        })
                        ->columns()
                        ->columnSpanFull()
                    ])
                    ->columns()
                    ->columnSpan(2),
                Section::make()
                    ->schema([
                        ComponentHelper::repeater('additional', [
                            TextInput::make('name'),
                            TextInput::make('price')
                                ->numeric(),
                        ])->default([
                            [
                                'name' => 'delivery',
                                'price' => 2
                            ]
                        ]),
                    ])
            ])
            ->columns(3);
    }
}
