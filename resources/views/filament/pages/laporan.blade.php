@php
    $data = $this->getData();
    $no = 1;
@endphp
<x-filament-panels::page>
    <div class="flex gap-2">

        <input type="date" wire:model='tgl_start' wire:change="getData" id="tlg_start" name="tgl_start"
            class="border rounded p-2">
        <input type="date" wire:model='tgl_end' id="tgl_end" name="tgl_end" class="border rounded p-2"
            wire:change="getData">
        <button type='button' class="w-40 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded"
            wire:click='generatePDF'>
            Download PDF
        </button>
    </div>



    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 p-1">#</th>
                <th class="border border-gray-300 p-1">Nama</th>
                <th class="border border-gray-300 p-1">Quantity</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
                <tr class="border-b border-gray-300">
                    <td class="border border-gray-300 p-1">{{ $no++ }}.</td>
                    <td class="border border-gray-300 p-1">{{ Str::upper($row->nasabah->name) }}</td>
                    <td class="border border-gray-300 p-1 text-center">{{ $row->total_quantity }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan='3' class='text-center'>No Data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</x-filament-panels::page>
<script src="https://cdn.tailwindcss.com"></script>
