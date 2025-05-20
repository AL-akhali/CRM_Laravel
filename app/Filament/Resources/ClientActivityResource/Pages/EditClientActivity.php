<?php

namespace App\Filament\Resources\ClientActivityResource\Pages;

use App\Filament\Resources\ClientActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientActivity extends EditRecord
{
    protected static string $resource = ClientActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
