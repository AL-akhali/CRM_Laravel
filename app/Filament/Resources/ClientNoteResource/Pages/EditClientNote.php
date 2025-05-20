<?php

namespace App\Filament\Resources\ClientNoteResource\Pages;

use App\Filament\Resources\ClientNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientNote extends EditRecord
{
    protected static string $resource = ClientNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
