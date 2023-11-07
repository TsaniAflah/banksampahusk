<?php

namespace App\Filament\User\Resources\PenarikanResource\Widgets;

use App\Models\Saldo;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class SaldoOverview extends BaseWidget
{
    // protected static string $view = 'filament.user.resources.penarikan-resource.widgets.saldo-overview';

    protected function getStats(): array
    {
        $saldo = Saldo::where('user_id', Auth::user()->id)->first();

        // Inisialisasi nilai default saldo
        $saldoText = 'Rp. 0';

        // Jika data saldo ditemukan, gunakan nilainya
        if ($saldo) {
            $saldoText = 'Rp. ' . number_format($saldo->saldo, 0, ',', '.');
        }

        return [
            Stat::make('Saldo Saat Ini', $saldoText),
        ];
    }
}
