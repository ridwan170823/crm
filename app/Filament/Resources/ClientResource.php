<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Client;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ClientResource\Pages;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'UserGroup';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $navigationLabel = 'Client';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('nama_institusi')
                                    ->label('Nama Institusi')
                                    ->required()
                                    ->maxLength(80)
                                    ->live(onBlur: true),
                                TextInput::make('nama_penanggung_jawab')
                                    ->label('Nama Penanggung Jawab')
                                    ->required()
                                    ->maxLength(50)
                                    ->live(onBlur: true),
                                TextInput::make('nik_penanggung_jawab')
                                    ->label('NIK Penanggung Jawab')
                                    ->required()
                                    ->numeric()
                                    ->maxLength(25)
                                    ->live(onBlur: true),
                                TextInput::make('nip_penanggung_jawab')
                                    ->label('NIP Penanggung Jawab')
                                    ->required()
                                    ->numeric()
                                    ->maxLength(25)
                                    ->live(onBlur: true),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->required()
                                    ->maxLength(50)
                                    ->live(onBlur: true)
                                    ->email()
                                    ->unique(Client::class, 'email', ignoreRecord: true),
                                PhoneInput::make('no_hp_institusi')
                                    ->label('No HP Institusi')
                                    ->required()
                                    ->live(onBlur: true),
                                PhoneInput::make('no_hp_penanggung_jawab')
                                    ->label('No HP Penanggung Jawab')
                                    ->required()
                                    ->live(onBlur: true),
                                TextInput::make('jabatan_penanggung_jawab')
                                    ->label('Jabatan Penanggung Jawab')
                                    ->required()
                                    ->maxLength(50)
                                    ->live(onBlur: true),
                            ])
                            ->columns(2),

                    ])
                    ->columnSpan(['lg' => 2]),

                Section::make()
                    ->schema([
                        MarkdownEditor::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),
                    ]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->label('Attachments')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('file_ktp_penanggung_jawab')
                                    ->collection('file_ktp_penanggung_jawab')
                                    ->label('File KTP Penanggung Jawab')
                                    ->required()
                                    ->openable()
                                    ->downloadable()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(2048),
                                SpatieMediaLibraryFileUpload::make('file_npwp_penanggung_jawab')
                                    ->collection('file_npwp_penanggung_jawab')
                                    ->label('File NPWP Penanggung Jawab')
                                    ->required()
                                    ->openable()
                                    ->downloadable()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(2048),
                                SpatieMediaLibraryFileUpload::make('file_npwp_institusi')
                                    ->collection('file_npwp_institusi')
                                    ->label('File NPWP Institusi')
                                    ->required()
                                    ->openable()
                                    ->downloadable()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(2048),
                                SpatieMediaLibraryFileUpload::make('legalitas_institusi')
                                    ->collection('legalitas_institusi')
                                    ->label('Legalitas Institusi')
                                    ->required()
                                    ->openable()
                                    ->downloadable()
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(2048),
                                SpatieMediaLibraryFileUpload::make('logo')
                                    ->collection('logo')
                                    ->label('Logo')
                                    ->required()
                                    ->openable()
                                    ->downloadable()
                                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml'])
                                    ->maxSize(1024),
                            ])
                            ->columns(2),

                    ])
                    ->columnSpan(['lg' => 2]),

            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->label('Logo')
                    ->collection('logo'),
                TextColumn::make('attachments')
                    ->state(function ($record) {
                        return $record->media()->count() > 0 ? 'Complete' : 'Incomplete';
                    })
                    ->label('Attachments'),
                TextColumn::make('nama_institusi')
                    ->label('Nama Institusi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama_penanggung_jawab')
                    ->label('Nama Penanggung Jawab')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_hp_institusi')
                    ->label('No HP Institusi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('no_hp_penanggung_jawab')
                    ->label('No HP Penanggung Jawab')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jabatan_penanggung_jawab')
                    ->label('Jabatan Penanggung Jawab')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->html(),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('nama_institusi'),
                        TextConstraint::make('nama_penanggung_jawab'),
                        TextConstraint::make('email'),
                        TextConstraint::make('no_hp_institusi'),
                        TextConstraint::make('no_hp_penanggung_jawab'),
                        TextConstraint::make('jabatan_penanggung_jawab'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
