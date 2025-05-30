<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;

class ClientNoteRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = '📝 ملاحظات العميل';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('content')
                ->label('✍️ الملاحظة')
                ->required()
                ->rows(5)
                ->placeholder('شارك ملاحظتك القيمة هنا...')
                ->columnSpan('full')
                ->maxLength(1000)
                ->reactive(),

            Forms\Components\Select::make('visibility')
                ->label('🔒 الظهور')
                ->options([
                    'public' => 'عامة 👁️',
                    'private' => 'خاصة 🔐',
                ])
                ->default('private')
                ->required()
                ->helperText('حدد من يمكنه رؤية هذه الملاحظة')
                ->columnSpan('full')
                ->reactive(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('visibility')
                    ->label('الظهور')
                    ->colors([
                        'public' => 'success',
                        'private' => 'danger',
                    ])
                    ->icons([
                        'public' => 'heroicon-o-eye',
                        'private' => 'heroicon-o-lock-closed',
                    ])
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('content')
                    ->label('الملاحظة')
                    ->limit(80)
                    ->wrap()
                    ->tooltip(fn ($record) => $record->content)
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('الموظف')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('visibility')
                    ->label('فلتر الظهور')
                    ->options([
                        'public' => 'عامة',
                        'private' => 'خاصة',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(' إضافة ملاحظة جديدة')
                    ->icon('heroicon-o-plus-circle')
                    ->button()
                    ->color('primary')
                    ->mutateFormDataUsing(fn (array $data): array => [
                        ...$data,
                        'user_id' => auth()->id(),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تعديل')
                    ->icon('heroicon-o-pencil')
                    ->button()
                    ->color('warning'),

                Tables\Actions\DeleteAction::make()
                    ->label(' حذف')
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('🗑️ حذف المحدد')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
            ]);
    }
}
