<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\Widget;

class TransactionSummary extends Widget
{
    protected static string $view = 'filament.widgets.transaction-summary';

    protected function getViewData(): array
    {
        return [
            'transactionsPerYear' => Transaction::selectRaw('YEAR(tanggal_faktur) as year, COUNT(*) as count')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get(),

            'latestTransactions' => Transaction::latest('tanggal_faktur')->take(5)->get(),
        ];
    }
}
