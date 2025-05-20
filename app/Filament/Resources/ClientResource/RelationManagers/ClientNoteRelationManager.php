<?php

// app/Filament/Resources/ClientResource/RelationManagers/ClientNoteRelationManager.php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\ClientNote;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ClientNoteRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = 'ملاحظات العميل';

//     protected function getTableQuery(): Builder
// {
//     $query = parent::getTableQuery();

//     if (!$query) {
//         throw new \Exception('Parent query is null. تحقق من العلاقة "notes" في موديل Client.');
//     }

//     $userId = auth()->id();

//     return $query->where(function ($query) use ($userId) {
//         $query->where('visibility', 'public')
//               ->orWhere(function ($query) use ($userId) {
//                   $query->where('visibility', 'private')
//                         ->where('user_id', $userId);
//               });
//     });
// }


    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('content')
                ->label('الملاحظة')
                ->required()
                ->rows(4),
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

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')->label('الملاحظة')->limit(50),
                Tables\Columns\TextColumn::make('user.name')->label('الموظف'),
                Tables\Columns\TextColumn::make('visibility')->label('الظهور'),
                Tables\Columns\TextColumn::make('created_at')->label('أضيفت في')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة ملاحظة العميل')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
