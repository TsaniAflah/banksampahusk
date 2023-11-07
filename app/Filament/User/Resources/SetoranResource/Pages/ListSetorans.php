<?php

namespace App\Filament\User\Resources\SetoranResource\Pages;

use App\Filament\User\Resources\PenarikanResource\Widgets\SaldoOverview;
use App\Filament\User\Resources\SetoranResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListSetorans extends ListRecords
{
    protected static string $resource = SetoranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            // Action::make('Tarik Saldo'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SaldoOverview::class,
        ];
    }
}
