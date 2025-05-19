<?php

namespace App\Filament\Resources\ClientContactResource\Pages;

use App\Filament\Resources\ClientContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientContacts extends ListRecords
{
    protected static string $resource = ClientContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
