<?php

namespace App\Filament\User\Resources\PenarikanResource\Pages;

use App\Filament\User\Resources\PenarikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenarikans extends ListRecords
{
    protected static string $resource = PenarikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PenarikanResource\Widgets\SaldoOverview::class,
        ];
    }
}
