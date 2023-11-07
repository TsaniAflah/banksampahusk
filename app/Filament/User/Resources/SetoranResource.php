<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\SetoranResource\Pages;
use App\Filament\User\Resources\SetoranResource\RelationManagers;
use App\Filament\User\Resources\SetoranResource\RelationManagers\ItemsRelationManager;
use App\Models\Nasabah;
use App\Models\Setoran;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SetoranResource extends Resource
{
    protected static ?string $model = Setoran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('number'),
                TextColumn::make('notes')->wrap(true),
                TextColumn::make('created_at')->label('Tanggal')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->modalContent(fn (Setoran $action): View => view('filament.pages.actions.detail-setoran', ['action' => $action]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
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
            ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSetorans::route('/'),
            // 'create' => Pages\CreateSetoran::route('/create'),
            'edit' => Pages\EditSetoran::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $nasabah = Nasabah::where('user_id', Auth::user()->id)->first();
        return parent::getEloquentQuery()->where('nasabah_id', $nasabah->id);
    }
}
