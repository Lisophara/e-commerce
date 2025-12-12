<?php

namespace App\Filament\Resources\Stores\Schemas;

use App\Filament\ComponentHelper;
use App\Services\UserServices;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use PHPUnit\Metadata\Group;

class StoreForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        Select::make('user_id')
                            ->searchable()
                            ->options(UserServices::getUsers()->pluck(fn ($array) => UserServices::getUserName($array), 'id'))
                            ->default(fn ($record) => $record->user_id)
                            ->required(),
                        TextInput::make('lat')
                            ->numeric(),
                        TextInput::make('long')
                            ->numeric(),
                        TextInput::make('contact'),
                        ComponentHelper::link('fb_link', '#*.?facebook.com$#')
                            ->columnSpanFull(),
                        ComponentHelper::link('ig_link')
                            ->columnSpanFull(),
                        ComponentHelper::link('tlg_link')
                            ->columnSpanFull(),
                        ComponentHelper::link('twitter_link')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
                \Filament\Schemas\Components\Group::make()
                    ->schema([
                        ComponentHelper::fileUpload('profile'),
                        ComponentHelper::fileUpload('cover'),
                    ])
                    ->columns(1)
            ])
            ->columns(3);
    }
}
