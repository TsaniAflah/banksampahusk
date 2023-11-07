<?php

namespace App\Filament\User\Resources\SetoranResource\RelationManagers;

use App\Models\SetoranItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('unit_price')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('unit_price')
            ->columns([
                Tables\Columns\TextColumn::make('jenis_sampah.name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('unit_price'),
                Tables\Columns\TextColumn::make('total')
                    ->default(fn (SetoranItem $item): string => $item->quantity * $item->unit_price)
                    ->money('idr', true)


            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
