<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientContactResource\Pages;
use App\Models\ClientContact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class ClientContactResource extends Resource
{
    protected static ?string $model = ClientContact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'جهات الاتصال';
    protected static ?string $pluralModelLabel = 'جهات الاتصال';
    protected static ?string $modelLabel = 'جهة اتصال';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('client_id')
                ->label('العميل')
                ->relationship('client', 'name')
                ->required(),

            TextInput::make('name')->label('الاسم')->required(),
            TextInput::make('email')->label('البريد الإلكتروني')->required()->email(),
            TextInput::make('phone')->label('رقم الهاتف'),
            TextInput::make('position')->label('الوظيفة'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('client.name')->label('العميل'),
            TextColumn::make('name')->label('الاسم'),
            TextColumn::make('email')->label('البريد الإلكتروني'),
            TextColumn::make('phone')->label('الهاتف'),
            TextColumn::make('position')->label('الوظيفة'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientContacts::route('/'),
            'create' => Pages\CreateClientContact::route('/create'),
            'edit' => Pages\EditClientContact::route('/{record}/edit'),
        ];
    }
}

