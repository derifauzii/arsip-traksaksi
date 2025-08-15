<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionStats extends ChartWidget
{
    protected static ?string $heading = 'Statistik Transaksi';
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    public function getFilters(): ?array
    {
        return [
            'year' => [
                'label' => 'Tahun',
                'options' => fn() => Transaction::selectRaw('YEAR(tanggal_faktur) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year', 'year')
                    ->toArray(),
                'default' => now()->year,
            ],
            'month' => [
                'label' => 'Bulan',
                'options' => collect(range(1, 12))
                    ->mapWithKeys(fn($m) => [$m => Carbon::create()->month($m)->translatedFormat('F')])
                    ->toArray(),
                'default' => null,
            ],
        ];
    }

    protected function getData(): array
    {
        $year = $this->filters['year'] ?? now()->year;
        $month = $this->filters['month'] ?? null;

        $query = Transaction::query()
            ->selectRaw('MONTH(tanggal_faktur) as month, COUNT(*) as count')
            ->whereYear('tanggal_faktur', $year);

        if ($month) {
            $query->whereMonth('tanggal_faktur', $month);
        }

        $raw = $query->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(fn($item) => [(int) $item->month => (int) $item->count])
            ->all();

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('F');
            $data[] = (int) ($raw[$i] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Transaksi',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // or 'bar'
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                        'beginAtZero' => true,
                    ],
                ],
            ],
        ];
    }
}
