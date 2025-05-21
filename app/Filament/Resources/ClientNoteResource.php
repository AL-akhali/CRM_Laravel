<?php

namespace App\Filament\Resources;
use App\Filament\Resources\ClientNoteResource\Pages;
use App\Filament\Resources\ClientNoteResource\RelationManagers;
use App\Models\ClientNote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Filters\SelectFilter;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientNoteResource extends Resource
{
    protected static ?string $model = ClientNote::class;
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = ' ملاحظات العملاء';
    protected static ?string $pluralModelLabel = 'ملاحظات العملاء';
    protected static ?string $modelLabel = 'ملاحظات العملاء';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('client_id')
                ->label('العميل')
                ->relationship('client', 'name')
                ->required(),
            Forms\Components\Textarea::make('content')
                ->label('الملاحظة')
                ->required()
                ->rows(4),
            Forms\Components\TextInput::make('user.name')
                ->label('الموظف')
                ->disabled()
                ->default(fn ($record) => $record?->user?->name ?? auth()->user()->name)
                ->required(),
            Forms\Components\Select::make('visibility')
                ->label('الظهور')
                ->options([
                    'public' => 'عامة',
                    'private' => 'خاصة',
                ])
                ->default('private')
                ->required(),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                $query->where('visibility', 'public')
                    ->orWhere(function ($query) {
                        $query->where('visibility', 'private')
                                ->where('user_id', auth()->id());
                    });
            });
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')->label('العميل'),
                Tables\Columns\TextColumn::make('content')->label('الملاحظة')->limit(50),
                Tables\Columns\TextColumn::make('user.name')->label('الموظف'),
                Tables\Columns\TextColumn::make('visibility')->label('الظهور'),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإضافة')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
            SelectFilter::make('visibility')
                ->label('الظهور')
                ->options([
                    'public' => 'عامة',
                    'private' => 'خاصة',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
