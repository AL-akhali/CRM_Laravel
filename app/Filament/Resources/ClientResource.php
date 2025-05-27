<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\MultiSelect;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\ClientResource\RelationManagers\ClientNoteRelationManager;

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
                TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('type')
                    ->label('النوع')
                    ->required()
                    ->options([
                        'فردي' => 'فردي',
                        'شركة' => 'شركة',
                    ]),

                TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('phone')
                    ->label('رقم الهاتف')
                    ->required(),

                TextInput::make('industry')
                    ->label('الصناعة'),

                Textarea::make('address')
                    ->label('العنوان'),

                Select::make('status')
                    ->label('الحالة')
                    ->required()
                    ->options([
                        'فعال' => 'فعال',
                        'غير فعال' => 'غير فعال',
                    ]),

                MultiSelect::make('tags')
                    ->label('العلامات')
                    ->relationship('tags', 'name')
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('filament.resources.clients.edit', $record)),

                TextColumn::make('type')
                    ->label('النوع')
                    ->sortable(),

                Tables\Columns\TagsColumn::make('tags.name')
                    ->label('العلامات')
                    ->limit(3),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('رقم الهاتف'),

                TextColumn::make('contacts_count')
                    ->label('عدد جهات الاتصال')
                    ->counts('contacts')
                    ->sortable(),

                TextColumn::make('tags_count')
                    ->label('عدد العلامات')
                    ->counts('tags')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tag')
                    ->label('تصفية حسب العلامة')
                    ->relationship('tags', 'name')
                    ->preload(),

                Filter::make('last_activity_after')
                    ->label('آخر نشاط بعد')
                    ->form([
                        DatePicker::make('date')->label('التاريخ'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['date'])) {
                            return $query->whereHas('activities', function ($q) use ($data) {
                                $q->whereDate('created_at', '>=', $data['date']);
                            });
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort(column: 'name');
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\ClientResource\RelationManagers\ContactsRelationManager::class,
            ClientNoteRelationManager::class,
            \App\Filament\Resources\ClientResource\RelationManagers\ActivitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ClientsDashboard::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
