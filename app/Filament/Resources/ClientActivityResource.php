<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientActivityResource\Pages;
use App\Models\ClientActivity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class ClientActivityResource extends Resource
{
    protected static ?string $model = ClientActivity::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationLabel = ' أنشطة العملاء';
    protected static ?string $pluralModelLabel = '⚡ أنشطة العملاء';
    protected static ?string $modelLabel = 'نشاط';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('📝 تفاصيل النشاط')
                ->schema([
                    Forms\Components\Select::make('client_id')
                        ->label('👤 العميل')
                        ->relationship('client', 'name')
                        ->required()
                        ->searchable()
                        ->placeholder('اختر العميل'),

                    Forms\Components\Select::make('type')
                        ->label('📌 نوع النشاط')
                        ->options([
                            'call' => 'مكالمة',
                            'email' => 'بريد إلكتروني',
                            'meeting' => 'اجتماع',
                            'note' => 'ملاحظة',
                            'update' => 'تحديث',
                        ])
                        ->required()
                        ->native(false)
                        ->placeholder('حدد نوع النشاط'),

                    Forms\Components\Textarea::make('description')
                        ->label('🗒️ الوصف')
                        ->required()
                        ->placeholder('أدخل وصفاً مختصراً للنشاط')
                        ->rows(4),
                ])->columns(1)->compact(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('👤 العميل')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('type')
                    ->label('نوع النشاط')
                    ->badge()
                    ->color(fn ($state) => [
                        'call' => 'primary',
                        'email' => 'success',
                        'meeting' => 'warning',
                        'note' => 'info',
                        'update' => 'danger',
                    ][$state] ?? 'gray')
                    ->formatStateUsing(fn ($state) => [
                        'call' => 'مكالمة',
                        'email' => 'بريد إلكتروني',
                        'meeting' => 'اجتماع',
                        'note' => 'ملاحظة',
                        'update' => 'تحديث',
                    ][$state] ?? $state),

                TextColumn::make('description')
                    ->label('🗒️ الوصف')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),

                TextColumn::make('created_at')
                    ->label('📅 التاريخ')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('client_id')
                    ->label('🔍 تصفية حسب العميل')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->placeholder('الكل'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('لا توجد أنشطة حالياً')
            ->emptyStateDescription('ابدأ بإضافة نشاط جديد للعميل')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('هل أنت متأكد؟')
                    ->modalDescription('سيتم حذف النشاط بشكل نهائي.'),
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
