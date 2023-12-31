<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Tables;
use App\Models\Client;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\KerjaSama;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\KerjaSamaResource\Pages;
use App\Filament\Resources\KerjaSamaResource\RelationManagers\ProdukKerjaSamaRelationManager;

class KerjaSamaResource extends Resource
{
    protected static ?string $model = KerjaSama::class;

    protected static ?string $navigationIcon =  'BuildingOffice';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Kerja Sama';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', 1)
            ->where('tanggal_selesai', '<', Carbon::now()->addDays(7)->toDateString())
            ->where('tanggal_selesai', '!=', Carbon::now()->toDateString())
            ->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema(fn (Get $get): array => [
                                Select::make('client_id')
                                    ->label('Client')
                                    ->required()
                                    ->options(Client::all()->pluck('nama_institusi', 'id'))
                                    ->searchable(),
                                TextInput::make('masa_kerja_sama')
                                    ->label('Masa Kerja Sama (Otomatis)')
                                    ->required()
                                    ->readOnly()
                                    ->suffix(' Hari')
                                    ->rule(['min' => 0, 'integer']),

                                DatePicker::make('tanggal_mulai')
                                    ->required()
                                    ->default(Carbon::now()),
                                DatePicker::make('tanggal_selesai')
                                    ->required()
                                    ->hintAction(
                                        Action::make('hitungMasaKerjaSama')
                                            ->action(function (Set $set, $state, Get $get) {
                                                $tanggal_mulai = $get('tanggal_mulai');
                                                $tanggal_selesai = $get('tanggal_selesai');

                                                if ($tanggal_mulai && $tanggal_selesai) {
                                                    $tanggal_mulai = Carbon::parse($tanggal_mulai);
                                                    $tanggal_selesai = Carbon::parse($tanggal_selesai);

                                                    $masa_kerja_sama = $tanggal_mulai->diffInDays($tanggal_selesai);

                                                    $set('masa_kerja_sama', $masa_kerja_sama);
                                                }
                                            })
                                    ),

                                TextInput::make('nilai_kerja_sama_bulanan')
                                    ->required()
                                    ->rule(['min' => 0])
                                    ->prefix('Rp. ')
                                    ->numeric()
                                    ->inputMode('decimal'),
                                TextInput::make('nilai_kerja_sama_semester')
                                    ->required()
                                    ->rule(['min' => 0])
                                    ->prefix('Rp. ')
                                    ->numeric()
                                    ->inputMode('decimal'),
                                TextInput::make('nilai_kerja_sama_tahunan')
                                    ->required()
                                    ->rule(['min' => 0])
                                    ->prefix('Rp. ')
                                    ->numeric()
                                    ->inputMode('decimal'),
                                Toggle::make('is_active')
                                    ->label('Status')
                                    ->required(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll("10s")
            ->recordClasses(fn (KerjaSama $kerjaSama): array => [
                $kerjaSama->is_active ? '' : 'opacity-50',
            ])
            ->columns([
                Tables\Columns\TextColumn::make('client.nama_institusi')
                    ->icon('BuildingOffice')
                    ->numeric()
                    ->color(fn (KerjaSama $kerjaSama): string => $kerjaSama->tanggal_selesai->isPast() ? 'danger' : (
                        $kerjaSama->tanggal_selesai->diffInDays(Carbon::now()) <= 7 ? 'warning' : ''))
                    ->sortable(),
                Tables\Columns\TextColumn::make('masa_kerja_sama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->date()
                    ->color(fn (KerjaSama $kerjaSama): string => $kerjaSama->tanggal_selesai->isPast() ? 'danger' : (
                        $kerjaSama->tanggal_selesai->diffInDays(Carbon::now()) <= 7 ? 'warning' : 'success'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai_kerja_sama_bulanan')
                    ->numeric()
                    ->sortable()
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('nilai_kerja_sama_semester')
                    ->numeric()
                    ->sortable()
                    ->money('IDR'),
                Tables\Columns\TextColumn::make('nilai_kerja_sama_tahunan')
                    ->numeric()
                    ->sortable()
                    ->money('IDR'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProdukKerjaSamaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKerjaSamas::route('/'),
            'edit' => Pages\EditKerjaSama::route('/{record}/edit'),
        ];
    }
}
