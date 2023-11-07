<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetoranResource\Pages;
use App\Filament\Resources\SetoranResource\RelationManagers;
use App\Filament\User\Resources\SetoranResource\RelationManagers\ItemsRelationManager;
use App\Models\JenisSampah;
use App\Models\Setoran;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SetoranResource extends Resource
{
    protected static ?string $model = Setoran::class;

    protected static ?string $navigationLabel = 'Setoran';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?string $navigationGroup = 'Setoran Sampah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->default('SETOR-' . random_int(100000, 9999999))
                            ->disabled()
                            ->dehydrated()
                            ->required(),

                        Forms\Components\Select::make('nasabah_id')
                            ->relationship('nasabah', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\MarkdownEditor::make('notes')
                            ->columnSpanFull(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nasabah.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

//                Tables\Columns\TextColumn::make('total_income')
//                    ->label('Pendapatan'),

                //Tables\Columns\TextColumn::make('total_weight'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal setor')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Detail')->modalContent(fn (Setoran $action): View => view('filament.pages.actions.detail-setoran', ['action' => $action]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
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
            ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSetorans::route('/'),
            'create' => Pages\CreateSetoran::route('/create'),
            'edit' => Pages\EditSetoran::route('/{record}/edit'),
        ];
    }
}
