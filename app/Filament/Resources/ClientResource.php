<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // أيقونة مناسبة للعملاء
    protected static ?string $navigationLabel = 'العملاء';
    protected static ?string $pluralModelLabel = 'العملاء';
    protected static ?string $modelLabel = 'عميل';
    public static function form(Forms\Form $form): Forms\Form
{
    return $form
        ->schema([
                TextInput::make('name')->label('الاسم')->required(),
                Select::make('type')
                    ->label('النوع')
                    ->required()
                    ->options([
                        'فردي' => 'فردي',
                        'شركة' => 'شركة',
                    ]),
                TextInput::make('email')->label('البريد الإلكتروني')->email()->required(),
                TextInput::make('phone')->label('رقم الهاتف')->required(),
                TextInput::make('industry')->label('الصناعة'),
                Textarea::make('address')->label('العنوان'),
                Select::make('status')
                    ->label('الحالة')
                    ->required()
                    ->options([
                        'فعال' => 'فعال',
                        'غير فعال' => 'غير فعال',
                    ]),
            ]);
}

    public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
                TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                TextColumn::make('type')->label('النوع')->sortable(),
                TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
                TextColumn::make('phone')->label('رقم الهاتف'),
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'success' => fn ($state) => $state === 'فعال',
                        'danger' => fn ($state) => $state === 'غير فعال',
                    ])
                    ->formatStateUsing(fn ($state) => $state),
            ])
            ->defaultSort('name');
}
    public static function getRelations(): array
{
    return [
        \App\Filament\Resources\ClientResource\RelationManagers\ContactsRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
