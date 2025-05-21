<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientActivityResource\Pages;
use App\Models\ClientActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class ClientActivityResource extends Resource
{
    protected static ?string $model = ClientActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'انشطه العملاء';
    protected static ?string $pluralModelLabel = 'انشطه العملاء';
    protected static ?string $modelLabel = 'نشاط عميل';

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
                Tables\Columns\TextColumn::make('client.name')
                    ->label('العميل')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('type')
                    ->label('نوع النشاط')
                    ->color(fn ($state) => match ($state) {
                        'call' => 'primary',
                        'email' => 'success',
                        'meeting' => 'warning',
                        'note' => 'info',
                        'update' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'email' => 'بريد إلكتروني',
                        'call' => 'مكالمة',
                        'meeting' => 'اجتماع',
                        'note' => 'ملاحظة',
                        'update' => 'تحديث',
                        default => $state,
                    }),
            //         IconColumn::make('type')
            // ->label('نوع النشاط')
            // ->icon(fn (string $state): string => match ($state) {
            //     'call' => 'heroicon-o-phone',
            //     'email' => 'heroicon-o-mail',
            //     'meeting' => 'heroicon-o-users',
            //     'note' => 'heroicon-o-document-text',
            //     'update' => 'heroicon-o-refresh',
            //     default => 'heroicon-o-question-mark-circle',
            // })
            // ->color(fn (string $state): string => match ($state) {
            //     'call' => 'primary',
            //     'email' => 'success',
            //     'meeting' => 'warning',
            //     'note' => 'info',
            //     'update' => 'danger',
            //     default => 'gray',
            // }),

                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('client_id')
                    ->label('تصفية حسب العميل')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->placeholder('الكل'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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
