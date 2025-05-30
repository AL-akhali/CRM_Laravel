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

class TagResource extends Resource
{
    protected static ?string $model = ClientTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'العلامات';
    protected static ?string $pluralModelLabel = 'العلامات';
    protected static ?string $modelLabel = 'علامة';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('اسم العلامة')
                ->required()
                ->unique(ignoreRecord: true)
                ->placeholder('مثال: هام، عاجل، متابعة'),

            Forms\Components\TextInput::make('color')
                ->label('لون العلامة')
                ->helperText('يمكنك إدخال كود HEX مثل #f59e0b أو اسم لون Tailwind مثل bg-yellow-400')
                ->placeholder('#f59e0b أو bg-yellow-400')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            BadgeColumn::make('name')
                ->label('اسم العلامة')
                ->formatStateUsing(fn (string $state) => Str::limit($state, 20))
                ->color(fn ($record) => null) // إلغاء اللون التلقائي لتطبيق اللون المخصص
                ->extraAttributes(fn ($record) => [
                    'style' => ($record->color && Str::startsWith($record->color, '#'))
                        ? "background-color: {$record->color}; color: white; font-weight: 600;"
                        : '',
                    'class' => ($record->color && !Str::startsWith($record->color, '#'))
                        ? "{$record->color} text-white font-semibold"
                        : 'bg-gray-300 text-gray-800 font-semibold',
                    'title' => $record->name, // تلميح عند المرور
                    'style' => ($record->color && Str::startsWith($record->color, '#'))
                        ? "background-color: {$record->color}; color: white; font-weight: 600; padding: 0.3rem 0.7rem; border-radius: 0.375rem;"
                        : '',
                ]),

            TextColumn::make('slug')
                ->label('الرابط (Slug)')
                ->sortable()
                ->searchable()
                ->tooltip(fn ($record) => "الرابط: {$record->slug}"),

            TextColumn::make('created_at')
                ->label('تاريخ الإضافة')
                ->dateTime('d M Y - h:i A')
                ->sortable(),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            Tables\Filters\Filter::make('created_recent')
                ->label('تم إضافتها حديثًا')
                ->query(fn ($query) => $query->where('created_at', '>=', now()->subDays(7))),
        ])
        ->actions([
            Tables\Actions\EditAction::make()->tooltip('تعديل العلامة'),
            Tables\Actions\DeleteAction::make()->tooltip('حذف العلامة'),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
