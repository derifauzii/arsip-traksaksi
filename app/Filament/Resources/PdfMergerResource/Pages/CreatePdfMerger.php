<?php

namespace App\Filament\Resources\PdfMergerResource\Pages;

use App\Filament\Resources\PdfMergerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePdfMerger extends CreateRecord
{
    protected static string $resource = PdfMergerResource::class;
}
