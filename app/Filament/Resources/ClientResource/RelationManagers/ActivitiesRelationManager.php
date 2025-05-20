<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $title = 'نشاطات العميل';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
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

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('نوع النشاط'),
                Tables\Columns\TextColumn::make('description')->label('الوصف')->limit(50),
                Tables\Columns\TextColumn::make('created_at')->label('التاريخ')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('إضافة انشطة العميل'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}

