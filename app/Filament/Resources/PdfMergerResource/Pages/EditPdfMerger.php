<?php

namespace App\Filament\Resources\PdfMergerResource\Pages;

use App\Filament\Resources\PdfMergerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPdfMerger extends EditRecord
{
    protected static string $resource = PdfMergerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
