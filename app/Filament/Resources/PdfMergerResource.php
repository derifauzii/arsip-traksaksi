<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PdfMergerResource\Pages;
use App\Filament\Resources\PdfMergerResource\RelationManagers;
use App\Models\PdfMerger;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use App\Services\PdfMergerService;

class PdfMergerResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $label = 'Gabung PDF';

    protected static ?string $pluralLabel = 'Gabung PDF';

    protected static ?string $navigationGroup = 'Tools';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transaction_ids')
                    ->label('Pilih Transaksi')
                    ->multiple()
                    ->options(
                        Transaction::with('company')
                            ->get()
                            ->mapWithKeys(fn($transaction) => [
                                $transaction->id => $transaction->company->name . ' - ' . $transaction->title . ' (' . $transaction->transaction_date->format('d/m/Y') . ')'
                            ])
                    )
                    ->searchable()
                    ->required()
                    ->helperText('Pilih beberapa transaksi untuk menggabungkan file PDF-nya'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pdf_count')
                    ->label('Jumlah PDF')
                    ->getStateUsing(fn(Transaction $record): int => count($record->pdf_files ?? [])),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company')
                    ->label('Perusahaan')
                    ->relationship('company', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('merge_single')
                    ->label('Gabung PDF')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Transaction $record) {
                        try {
                            if (count($record->pdf_files ?? []) < 2) {
                                Notification::make()
                                    ->title('Tidak bisa menggabung PDF')
                                    ->body('Transaksi harus memiliki minimal 2 file PDF')
                                    ->warning()
                                    ->send();
                                return;
                            }

                            $mergerService = app(PdfMergerService::class);
                            $mergedPath = $mergerService->mergeTransactionPdfs($record->id);

                            $fileExtension = pathinfo($mergedPath, PATHINFO_EXTENSION);
                            $message = $fileExtension === 'zip' ?
                                'File PDF dikemas dalam ZIP (library PDF merger tidak tersedia)' :
                                'File PDF berhasil digabung';

                            Notification::make()
                                ->title('Berhasil')
                                ->body($message)
                                ->success()
                                ->actions([
                                    \Filament\Notifications\Actions\Action::make('download')
                                        ->label('Unduh')
                                        ->url(asset('storage/' . $mergedPath))
                                        ->openUrlInNewTab(),
                                ])
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal menggabung PDF')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->visible(fn(Transaction $record) => count($record->pdf_files ?? []) > 1),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('merge_selected')
                    ->label('Gabung PDF Terpilih')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function ($records) {
                        try {
                            $allPdfFiles = [];
                            $companyNames = [];

                            foreach ($records as $record) {
                                if (!empty($record->pdf_files)) {
                                    $allPdfFiles = array_merge($allPdfFiles, $record->pdf_files);
                                    $companyNames[] = $record->company->name;
                                }
                            }

                            if (empty($allPdfFiles)) {
                                throw new \Exception('Tidak ada file PDF untuk digabung');
                            }

                            $outputFileName = 'merged_bulk_' . time() . '.pdf';
                            $outputPath = 'transactions/merged/' . $outputFileName;

                            \Illuminate\Support\Facades\Storage::makeDirectory('transactions/merged');

                            $mergerService = app(PdfMergerService::class);
                            $mergedPath = $mergerService->mergePdfs($allPdfFiles, $outputPath);

                            $fileExtension = pathinfo($mergedPath, PATHINFO_EXTENSION);
                            $message = $fileExtension === 'zip' ?
                                'File PDF dikemas dalam ZIP' :
                                'File PDF berhasil digabung';

                            Notification::make()
                                ->title('Berhasil')
                                ->body($message . ' dari ' . implode(', ', array_unique($companyNames)))
                                ->success()
                                ->actions([
                                    \Filament\Notifications\Actions\Action::make('download')
                                        ->label('Unduh')
                                        ->url(asset('storage/' . $mergedPath))
                                        ->openUrlInNewTab(),
                                ])
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal menggabung PDF')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('transaction_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPdfMergers::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
