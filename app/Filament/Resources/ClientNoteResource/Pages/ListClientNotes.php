<?php

namespace App\Filament\Resources\ClientNoteResource\Pages;

use App\Filament\Resources\ClientNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientNotes extends ListRecords
{
    protected static string $resource = ClientNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
