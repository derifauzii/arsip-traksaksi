<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;
    protected static string $view = 'filament.resources.transaction-resource.pages.view-transaction';


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    // public function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             Infolists\Components\Section::make('Informasi Transaksi')
    //                 ->schema([
    //                     Infolists\Components\Grid::make(2)
    //                         ->schema([
    //                             Infolists\Components\TextEntry::make('company.name')
    //                                 ->label('Perusahaan'),

    //                             Infolists\Components\TextEntry::make('company.account_number')
    //                                 ->label('Nomor Rekening'),

    //                             Infolists\Components\TextEntry::make('title')
    //                                 ->label('Judul Transaksi'),

    //                             Infolists\Components\TextEntry::make('transaction_date')
    //                                 ->label('Tanggal Transaksi')
    //                                 ->date('d/m/Y'),
    //                         ]),

    //                     Infolists\Components\TextEntry::make('notes')
    //                         ->label('Catatan')
    //                         ->columnSpanFull()
    //                         ->placeholder('Tidak ada catatan'),
    //                 ]),

    //             Infolists\Components\Section::make('File PDF')
    //                 ->schema([
    //                     Infolists\Components\RepeatableEntry::make('pdf_files')
    //                         ->label('')
    //                         ->schema([
    //                             Infolists\Components\TextEntry::make('file')
    //                                 ->label('Nama File')
    //                                 ->getStateUsing(fn($state) => basename($state))
    //                                 ->suffixActions([
    //                                     Infolists\Components\Actions\Action::make('view')
    //                                         ->label('Lihat')
    //                                         ->icon('heroicon-m-eye')
    //                                         ->url(fn($state) => asset('storage/' . $state))
    //                                         ->openUrlInNewTab(),
    //                                     Infolists\Components\Actions\Action::make('download')
    //                                         ->label('Unduh')
    //                                         ->icon('heroicon-m-arrow-down-tray')
    //                                         ->url(fn($state) => asset('storage/' . $state))
    //                                         ->openUrlInNewTab(),
    //                                 ]),
    //                         ])
    //                         ->columns(1)
    //                         ->visible(fn($record) => !empty($record->pdf_files)),

    //                     Infolists\Components\TextEntry::make('empty_files')
    //                         ->label('')
    //                         ->getStateUsing(fn() => 'Tidak ada file PDF yang tersedia')
    //                         ->visible(fn($record) => empty($record->pdf_files)),
    //                 ]),
    //         ]);
    // }
}
