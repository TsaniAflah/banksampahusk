<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\PenarikanResource\Pages;
use App\Filament\User\Resources\PenarikanResource\RelationManagers;
use App\Filament\User\Resources\PenarikanResource\Widgets\SaldoOverview;
use App\Models\Penarikan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PenarikanResource extends Resource
{
    protected static ?string $model = Penarikan::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Sekarang')
                            ->readOnly()
                            ->default(now()),
                        Forms\Components\TextInput::make('jumlah_penarikan')
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 2),
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan'),
                        Forms\Components\Hidden::make('user_id')
                            ->default(Auth::user()->id)

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            // 'edit' => Pages\EditPenarikan::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            SaldoOverview::class
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id);
    }
}
