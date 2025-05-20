<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientActivityResource\Pages;
use App\Filament\Resources\ClientActivityResource\RelationManagers;
use App\Models\ClientActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientActivityResource extends Resource
{
    protected static ?string $model = ClientActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = ' انشطه العملاء';
    protected static ?string $pluralModelLabel = 'انشطه العملاء';
    protected static ?string $modelLabel = 'انشطه العملاء';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('client_id')
                ->label('العميل')
                ->relationship('client', 'name')
                ->required(),
            Forms\Components\Select::make('type')
                ->label('نوع النشاط')
                ->options([
                    'call' => 'مكالمة',
                    'email' => 'بريد إلكتروني',
                    'meeting' => 'اجتماع',
                    'note' => 'ملاحظة',
                    'update' => 'تحديث',
                ])
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label('الوصف')
                ->required()
                ->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')->label('العميل')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('type')->label('نوع النشاط')->sortable(),
                Tables\Columns\TextColumn::make('description')->label('الوصف')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('التاريخ')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // تقدر تضيف فلاتر هنا لو تريد
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListClientActivities::route('/'),
            'create' => Pages\CreateClientActivity::route('/create'),
            'edit' => Pages\EditClientActivity::route('/{record}/edit'),
        ];
    }
}
