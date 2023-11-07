<?php

namespace App\Filament\Pages;

use App\Models\Setoran;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class Laporan extends Page
{
    // use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.laporan';

    public $tgl_start = '';
    public $tgl_end = '';
    public $data = [];

    public function getData()
    {
        $query = Setoran::query();
        $query = $query->join('setoran_items', 'setorans.id', '=', 'setoran_items.setoran_id')
            ->select('setorans.nasabah_id', DB::raw('SUM(setoran_items.quantity) as total_quantity'))
            ->groupBy('setorans.nasabah_id');

        if ($this->tgl_start != '') {
            $query->where('setorans.created_at', '>=', $this->tgl_start);
        }

        if ($this->tgl_end != '') {
            $query->where('setorans.created_at', '<=', $this->tgl_end);
        }

        $data = $query->get();

        return $data;
    }

    public function generatePDF()

    {

        // $query = Setoran::query();
        $data = $this->getData();

        $pdf = PDF::loadView('laporan', ['data' => $data]);

        $tanggal = Carbon::now();
        $laporanString = 'laporan-' . $tanggal->format('d-m-Y');

        // $pdf->download('cek.pdf');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, $laporanString . '.pdf');
    }
}
