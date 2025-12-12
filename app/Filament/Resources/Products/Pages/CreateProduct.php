<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected static ?string $navigationLabel = 'Product';

    protected function handleRecordCreation(array $data): Model
    {
        $data['created_by'] = auth()->id();
        return parent::handleRecordCreation($data);
    }
}
