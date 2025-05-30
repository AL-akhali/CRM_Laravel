<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientNoteResource\Pages;
use App\Models\ClientNote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class ClientNoteResource extends Resource
{
    protected static ?string $model = ClientNote::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'ملاحظات العملاء';
    protected static ?string $pluralModelLabel = 'ملاحظات العملاء';
    protected static ?string $modelLabel = 'ملاحظة عميل';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\Select::make('client_id')
                        ->label('العميل')
                        ->relationship('client', 'name')
                        ->required()
                        ->searchable()
                        ->columnSpan(1),

                    Forms\Components\Select::make('visibility')
                        ->label('الظهور')
                        ->options([
                            'public' => 'عامة',
                            'private' => 'خاصة',
                        ])
                        ->default('private')
                        ->required()
                        ->columnSpan(1),
                ]),

            Forms\Components\Textarea::make('content')
                ->label('محتوى الملاحظة')
                ->required()
                ->autosize()
                ->rows(5),

            Forms\Components\TextInput::make('user.name')
                ->label('الموظف')
                ->disabled()
                ->default(fn ($record) => $record?->user?->name ?? auth()->user()->name)
                ->dehydrated(false),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(fn ($query) => $query
                ->where('visibility', 'public')
                ->orWhere(function ($query) {
                    $query->where('visibility', 'private')
                        ->where('user_id', auth()->id());
                }));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('العميل')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('الموظف')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('visibility')
                    ->label('الظهور')
                    ->colors([
                        'success' => 'public',
                        'warning' => 'private',
                    ])
                    ->formatStateUsing(fn ($state) => $state === 'public' ? 'عامة' : 'خاصة'),

                TextColumn::make('content')
                    ->label('الملاحظة')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->content),

                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('client_id')
                    ->label('العميل')
                    ->relationship('client', 'name')
                    ->searchable(),

                SelectFilter::make('visibility')
                    ->label('الظهور')
                    ->options([
                        'public' => 'عامة',
                        'private' => 'خاصة',
                    ])
                    ->placeholder('الكل'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->tooltip('تعديل الملاحظة'),
                Tables\Actions\DeleteAction::make()->tooltip('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف جماعي'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientNotes::route('/'),
            'create' => Pages\CreateClientNote::route('/create'),
            'edit' => Pages\EditClientNote::route('/{record}/edit'),
        ];
    }
}
