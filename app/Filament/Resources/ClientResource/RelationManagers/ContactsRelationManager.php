<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return 'جهات الاتصال';
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('الاسم')
                ->required()
                ->maxLength(255)
                ->placeholder('أدخل اسم جهة الاتصال')
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Str::slug($state)))
                ->columnSpan('full'),

            Forms\Components\TextInput::make('email')
                ->label('البريد الإلكتروني')
                ->email()
                ->required()
                ->maxLength(255)
                ->placeholder('example@mail.com')
                ->columnSpan(6),

            Forms\Components\TextInput::make('phone')
                ->label('رقم الهاتف')
                ->tel()
                ->maxLength(20)
                ->placeholder('+966 5X XXX XXXX')
                ->columnSpan(6),

            Forms\Components\TextInput::make('position')
                ->label('المنصب')
                ->maxLength(255)
                ->placeholder('المنصب الوظيفي')
                ->columnSpan('full'),
        ])->columns(12);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->wrap()
                    ->extraAttributes(['class' => 'font-semibold text-indigo-600']),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => "<a href='mailto:$state' class='text-blue-500 underline'>$state</a>")
                    ->html(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => "<a href='tel:$state' class='text-green-600'>$state</a>")
                    ->html(),

                Tables\Columns\TextColumn::make('position')
                    ->label('المنصب')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة جهة اتصال')
                    ->icon('heroicon-o-plus')
                    ->button()
                    ->color('primary'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تعديل')
                    ->icon('heroicon-o-pencil')
                    ->button()
                    ->color('warning'),

                Tables\Actions\DeleteAction::make()
                    ->label('حذف')
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('حذف المحدد')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('created_last_30_days')
                    ->label('آخر 30 يوم')
                    ->query(fn ($query) => $query->where('created_at', '>=', now()->subDays(30))),
            ]);
    }
}
