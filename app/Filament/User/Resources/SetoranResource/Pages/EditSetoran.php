<?php

namespace App\Filament\User\Resources\SetoranResource\Pages;

use App\Filament\User\Resources\SetoranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class EditSetoran extends EditRecord
{
    protected static string $resource = SetoranResource::class;

    public function getTitle(): string|Htmlable
    {
        return "Detail Setoran " . Auth::user()->name;
    }


    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getFormActions(): array
    {
        return [];
    }
}
