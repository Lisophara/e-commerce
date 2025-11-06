<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\ComponentHelper;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('product.section.details'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('product.title'))
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('code')
                            ->label(__('product.code'))
                            ->maxLength(64),
                        ComponentHelper::numeric('price')
                            ->label(__('product.price'))
                            ->required(),
                        CheckBox::make('published')
                            ->extraFieldWrapperAttributes([
                                'style' => 'margin-top: auto; margin-bottom: auto;',
                                'class' => 'ssdasd'
                            ])
                            ->label(__('product.published')),
                        ComponentHelper::richEditor('description')
                            ->label(__('product.description'))
                            ->columnSpanFull()
                    ])
                    ->columns(2)
                    ->columnSpan(2),
                Section::make(__('product.section.image'))
                    ->schema([
                        ComponentHelper::fileUpload('images')
                            ->label(__('product.image'))
                            ->multiple()
                            ->required(),
                    ])
                    ->collapsible()
                    ->columns(1)
                ->columnSpan(1),
            ])->columns(3);
    }
}
