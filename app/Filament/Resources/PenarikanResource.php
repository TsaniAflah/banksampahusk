<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenarikanResource\Pages;
use App\Filament\Resources\PenarikanResource\RelationManagers;
use App\Models\Penarikan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenarikanResource extends Resource
{
    protected static ?string $model = Penarikan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Sekarang')
                            ->readOnly(),
                        Forms\Components\TextInput::make('jumlah_penarikan')
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2)
                            ->readOnly(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'waiting' => 'Waiting',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak'
                            ]),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan'),
                        Forms\Components\FileUpload::make('bukti_transfer')
                            ->label('Bukti Transfer')
                            ->directory('buktitransfer')
                            ->nullable(),



                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('tanggal'),
                TextColumn::make('jumlah_penarikan')->currency('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'waiting' => 'gray',
                        'ditolak' => 'danger',
                        'disetujui' => 'success',
                    }),
                ImageColumn::make('bukti_transfer')
                    ->label('Bukti Transfer')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenarikans::route('/'),
            'create' => Pages\CreatePenarikan::route('/create'),
            'edit' => Pages\EditPenarikan::route('/{record}/edit'),
        ];
    }
}
