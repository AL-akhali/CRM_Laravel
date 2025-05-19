<?php

namespace App\Filament\Resources\ClientContactResource\Pages;

use App\Filament\Resources\ClientContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientContact extends EditRecord
{
    protected static string $resource = ClientContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
