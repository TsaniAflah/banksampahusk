<?php

namespace App\Filament\Resources\SetoranResource\Pages;

use App\Filament\Resources\SetoranResource;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Saldo;
use App\Models\Setoran;
use App\Models\SetoranItem;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

class CreateSetoran extends CreateRecord
{

    protected static string $resource = SetoranResource::class;

    // protected static string $view = 'filament.forms.components.create-setoran';

    // protected function getRedirectUrl(): string
    // {
    //     //create saldos
    //     $saldo = Saldo::where('user_id', 1)->first();
    //     if (!$saldo) {
    //         Saldo::create(['saldo' => 0, 'user_id' => Auth::user()->id]);
    //     }

    //     return $this->getResource()::getUrl('index');
    // }
    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
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

                Section::make()
//                    ->columns([
//                        'sm' => 1,
//                        'xl' => 4,
//                    ])
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->schema([
                                Forms\Components\Select::make('jenis_sampah_id')
                                    ->label('Jenis Sampah')
                                    ->options(JenisSampah::query()->pluck('name', 'id'))
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('unit_price', JenisSampah::find($state)?->price ?? 0)),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Total Berat')
                                    ->numeric()
                                    ->live()
                                    ->dehydrated()
                                    ->rules('regex:/^\d{1,6}(\.\d{0,2})?$/')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, $get) {
                                        $set('total_income', ($state * $get('unit_price')));
                                    }),

                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->required(),

                                //                                    Forms\Components\Placeholder::make('total_income')
                                //                                        ->label('Total Pendapatan')
                                //                                        ->content(function ($get) {
                                //                                            $quantity = floatval($get('quantity'));
                                //                                            $unitPrice = floatval($get('unit_price'));
                                //                                            return $quantity * $unitPrice;
                                //                                        }),

                                Forms\Components\TextInput::make('total_income')
                                    ->label('Total Pendapatan')
                                    ->disabled()

                            ])
                    ])

            ]);
    }

    // public $quantity = [];
    public function create(bool $another = false): void
    {
        $get = $this->all();
        $data = $get['data'];

        // insert to setoran
        $setoran = Setoran::where('number', $data['number'])->first();
        if (!$setoran) {
            $setoran = Setoran::create([
                'nasabah_id' => $data['nasabah_id'],
                'number' => $data['number'],
                'notes' => $data['notes']
            ]);
        }

        //ceck saldo exist
        $nasabah = Nasabah::find($data['nasabah_id']);
        $saldos = Saldo::where('user_id', $nasabah->user_id)->first();
        if (!$saldos) {
            Saldo::create(['saldo' => 0, 'user_id' => $nasabah->user_id]);
        }

        if ($setoran) {
            foreach ($data['items'] as $items) {
                SetoranItem::create([
                    'setoran_id' => $setoran->id,
                    'jenis_sampah_id' => $items['jenis_sampah_id'],
                    'quantity' => $items['quantity'],
                    'unit_price' => $items['unit_price']
                ]);
            }

            Notification::make()
                ->title('Saved successfully')
                ->success()
                ->send();

            redirect()->to($this->getResource()::getUrl('index'));
        }
    }
}
