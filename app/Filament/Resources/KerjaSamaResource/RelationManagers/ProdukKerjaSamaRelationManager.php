<?php

namespace App\Filament\Resources\KerjaSamaResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Fitur;
use App\Models\FiturKerjaSama;
use App\Models\Produk;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Date;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ProdukKerjaSamaRelationManager extends RelationManager
{
    protected static string $relationship = 'produkKerjaSama';

    public ?array $fitursData = [];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('produk_id')
                    ->label('Produk')
                    ->required()
                    ->options(Produk::all()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (Select $component) => $component
                        ->getContainer()
                        ->getComponent('dynamicFields')
                        ->getChildComponentContainer()
                        ->fill()),
                Grid::make(1)
                    ->schema(fn (Get $get): array => [
                        $get('produk_id') ?
                            CheckboxList::make('fitur_id')
                            ->searchable()
                            ->bulkToggleable()
                            ->label('Fitur')
                            ->relationship('fiturs', 'name', function (Builder $query) use ($get) {
                                $query->where('produk_id', $get('produk_id'));
                            })
                            ->columns(4)
                            ->gridDirection('row')
                            ->noSearchResultsMessage('Tidak ada fitur yang tersedia untuk produk ini.')
                            ->searchPrompt('Cari fitur...')

                            : Placeholder::make('fitur')
                            ->content('Pilih produk terlebih dahulu.')
                    ])
                    ->key('dynamicFields')
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('kerja_samas_id')
            ->columns([
                TextColumn::make('produk.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('fiturs.name')
                    ->listWithLineBreaks()
                    ->expandableLimitedList(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
