<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\ViewColumn;

class LatestTransactions extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Transaksi Terbaru';

    protected function getTableQuery(): Builder
    {
        return Transaction::query()
            ->latest('tanggal_faktur')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('tanggal_faktur')
                ->label('Tanggal')
                ->date('d M Y')
                ->sortable(),

            TextColumn::make('title')
                ->label('Judul')
                ->searchable(),

            TextColumn::make('company.name')
                ->label('Perusahaan')
                ->searchable(),

            TextColumn::make('kode_kegiatan')
                ->label('Kode Kegiatan'),
        ];
    }
}
