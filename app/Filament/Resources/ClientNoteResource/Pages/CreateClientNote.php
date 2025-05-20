<?php

namespace App\Filament\Resources\ClientNoteResource\Pages;

use App\Filament\Resources\ClientNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClientNote extends CreateRecord
{
    protected static string $resource = ClientNoteResource::class;
}
