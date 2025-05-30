<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientContactResource\Pages;
use App\Models\ClientContact;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Validation\Rule;

class ClientContactResource extends Resource
{
    protected static ?string $model = ClientContact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = '📞 جهات الاتصال';
    protected static ?string $pluralModelLabel = 'جهات الاتصال';
    protected static ?string $modelLabel = 'جهة اتصال';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('🧾 بيانات جهة الاتصال')
                ->description('يرجى تعبئة كافة الحقول الخاصة بجهة الاتصال بدقة.')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('client_id')
                            ->label('👤 العميل')
                            ->relationship('client', 'name')
                            ->required()
                            ->searchable()
                            ->placeholder('اختر العميل'),

                        TextInput::make('name')
                            ->label('📝 الاسم')
                            ->required()
                            ->placeholder('أدخل اسم جهة الاتصال'),

                        TextInput::make('email')
                            ->label('📧 البريد الإلكتروني')
                            ->required()
                            ->email()
                            ->placeholder('example@email.com')
                            ->rules(function (callable $get) {
                                return [
                                    Rule::unique('client_contacts', 'email')
                                        ->where(fn($query) => $query->where('client_id', $get('client_id')))
                                        ->ignore($get('id')),
                                ];
                            }),

                        TextInput::make('phone')
                            ->label('📱 رقم الهاتف')
                            ->tel()
                            ->placeholder('05XXXXXXXX'),

                        TextInput::make('position')
                            ->label('💼 الوظيفة')
                            ->placeholder('مثال: مدير مبيعات'),
                    ]),
                ])->columns(1)->compact(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('👤 العميل')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('name')
                    ->label('📝 الاسم')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->email),

                BadgeColumn::make('email')
                    ->label('📧 البريد الإلكتروني')
                    ->colors(['success'])
                    ->icons(['heroicon-o-envelope']),

                TextColumn::make('phone')
                    ->label('📱 الهاتف')
                    ->icon('heroicon-o-phone-arrow-up-right')
                    ->copyable(),

                BadgeColumn::make('position')
                    ->label('💼 الوظيفة')
                    ->colors([
                        'info' => fn($state) => $state === 'مدير',
                        'success' => fn($state) => str_contains($state, 'مبيعات'),
                        'warning' => fn($state) => $state === null,
                        'gray' => fn($state) => true,
                    ])
                    ->placeholder('غير محددة'),
            ])
            ->defaultSort('name')
            ->paginationPageOptions([10, 25, 50])
            ->striped()
            ->filters([])
            ->searchPlaceholder('ابحث باسم أو بريد...');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientContacts::route('/'),
            'create' => Pages\CreateClientContact::route('/create'),
            'edit' => Pages\EditClientContact::route('/{record}/edit'),
        ];
    }
}
