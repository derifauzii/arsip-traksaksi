<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestTransactions;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    protected function getFooterWidgets(): array
    {
        return [
            // LatestTransactions::class,
        ];
    }
}
