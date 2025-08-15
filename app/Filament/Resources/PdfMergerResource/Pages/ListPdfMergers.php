<?php

namespace App\Filament\Resources\PdfMergerResource\Pages;

use App\Filament\Resources\PdfMergerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPdfMergers extends ListRecords
{
    protected static string $resource = PdfMergerResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
