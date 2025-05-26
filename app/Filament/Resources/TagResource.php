<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\ClientTag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
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
            ->color(fn ($record) => null) // تبقي null أو ممكن تحذفها لو مش محتاجها
            ->formatStateUsing(fn ($state) => $state)
            ->extraAttributes(fn ($record) => [
                'style' => ($record->color && Str::startsWith($record->color, '#'))
                    ? "background-color: {$record->color}; color: white;"
                    : '',
                'class' => ($record->color && !Str::startsWith($record->color, '#'))
                    ? "{$record->color} text-white"
                    : '',
            ]),
            // TextColumn::make('name')
            //     ->label('الاسم (ملون)')
            //     ->formatStateUsing(fn ($state) => $state)
            //     ->extraAttributes(fn ($record) => [
            //         'style' => ($record->color && Str::startsWith($record->color, '#'))
            //             ? "background-color: {$record->color}; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem;"
            //             : '',
            //         'class' => ($record->color && !Str::startsWith($record->color, '#'))
            //             ? "{$record->color} text-white px-2 py-1 rounded"
            //             : '',
            //     ]),
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
