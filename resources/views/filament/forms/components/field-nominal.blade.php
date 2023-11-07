<label>Jumlah Penarikan</label>
<div x-data="{ state: $wire.$entangle('jumlah_penarikan') }">
    <input x-mask:dynamic="$money($input)"
        class="fi-input block w-full border bg-transparent py-1.5 text-base text-gray-950 rounded-sm rounded border-gray-300 focus:border-green-600"
        wire:model="state">
</div>
