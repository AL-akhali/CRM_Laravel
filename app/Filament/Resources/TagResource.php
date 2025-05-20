<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\ClientTag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TagResource extends Resource
{
    protected static ?string $model = ClientTag::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $label = 'علامة';
    protected static ?string $pluralLabel = 'العلامات';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('الاسم')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('color')
                ->label('اللون (كود HEX أو Tailwind)')
                ->placeholder('#facc15 أو bg-yellow-400')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            BadgeColumn::make('name')
                ->label('الاسم (ملون)')
                ->color(fn ($record) => null)
                ->formatStateUsing(fn ($state) => $state)
                ->extraAttributes(fn ($record) => [
                    'style' => $record->color && str($record->color)->startsWith('#')
                        ? "background-color: {$record->color}; color: white;"
                        : '',
                    'class' => $record->color && !str($record->color)->startsWith('#')
                        ? $record->color . ' text-white'
                        : '',
                ]),
            Tables\Columns\TextColumn::make('slug')->label('Slug'),
            Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإضافة')->dateTime(),
        ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
