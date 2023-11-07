<div>
    <table class="w-full">
        <thead>
            <tr>
                <th>No.</th>
                <th
                    class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                    Jenis Sampah</th>
                <th
                    class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                    Quantity</th>
                <th
                    class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                    Harga</th>
                <th
                    class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                    Total</th>

            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @forelse ($action->items as $row)
                <tr class='p-2 border'>
                    <td class='text-center'>{{ $no++ }}</td>
                    <td class='ml-2'>{{ $row->jenis_sampah->name }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td class='text-right'>@currency($row->unit_price)</td>

                    <td class='text-right'>
                        @php
                            $total = $row->unit_price * $row->quantity;
                        @endphp
                        @currency($total)
                    </td>
                </tr>
        </tbody>

    @empty
        @endforelse
        </thead>
</div>
