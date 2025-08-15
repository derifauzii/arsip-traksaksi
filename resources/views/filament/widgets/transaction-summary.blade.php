<x-filament::widget>
    <x-filament::card>
        <h2 class="mb-4 text-lg font-bold">Transaksi per Tahun</h2>
        <ul class="mb-6">
            @foreach ($transactionsPerYear as $item)
                <li>{{ $item->year }}: {{ $item->count }} transaksi</li>
            @endforeach
        </ul>

        <h2 class="mb-4 text-lg font-bold">5 Transaksi Terbaru</h2>
        <ul>
            @foreach ($latestTransactions as $tx)
                <li>
                    <strong>{{ $tx->judul_transaksi }}</strong> -
                    {{ $tx->tanggal_faktur->format('d M Y') }}
                </li>
            @endforeach
        </ul>
    </x-filament::card>
</x-filament::widget>
