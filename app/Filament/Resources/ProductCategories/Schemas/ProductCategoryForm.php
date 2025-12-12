<?php

namespace App\Filament\Resources\ProductCategories\Schemas;

use App\Filament\ComponentHelper;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('label')->schema([
                    TextInput::make('name')
                        ->label(__('messages.name')),
                    TextInput::make('label')
                        ->label(__('messages.label')),
                    ComponentHelper::richEditor('description')
                        ->label(__('messages.description')),
                ])
                ->columns()
                ->columnSpanFull()
            ]);
    }
}
