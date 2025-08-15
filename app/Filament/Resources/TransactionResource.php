<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $label = 'Transaksi';

    protected static ?string $pluralLabel = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->required()
                    ->suffixAction(
                        Action::make('createCompany')
                            ->icon('heroicon-o-plus')
                            ->tooltip('Tambah Perusahaan')
                            ->url(route('filament.admin.resources.companies.create'))
                    ),

                TextInput::make('kode_kegiatan')
                    ->label('Kode Kegiatan')
                    ->mask('99.99.99.99.9999')
                    ->placeholder('00.00.00.00.1234')
                    ->rules(['required', 'regex:/^\d{2}\.\d{2}\.\d{2}\.\d{2}\.\d{4}$/'])
                    ->dehydrateStateUsing(fn($state) => $state) // jika ingin disimpan dengan titik
                    // ->dehydrateStateUsing(fn ($state) => str_replace('.', '', $state)) // jika ingin tanpa titik
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\DatePicker::make('tanggal_faktur')
                    ->label("Tanggal Faktur")
                    ->displayFormat('d/m/Y')
                    ->required(),

                Forms\Components\FileUpload::make('pdf_files')
                    ->acceptedFileTypes(['application/pdf'])
                    ->placeholder('Klik untuk unggah bukti pembayaran')
                    ->multiple()
                    ->directory('transactions')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->required()
                    ->helperText('Upload file PDF bukti transaksi dan pembayaran'),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label("Nama Perusahaan")
                    ->numeric()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kode_kegiatan')
                    ->label('Kode Kegiatan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label("Judul Tansaksi")
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_faktur')
                    ->date("d/m/Y")
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_pdf')
                    ->label("Total PDF")
                    ->getStateUsing(fn(Transaction $record): int => count($record->pdf_files ?? [])),

                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),

                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('company')
                    ->relationship('company', 'name'),
                SelectFilter::make('month')
                    ->label('Bulan')
                    ->options([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['value'],
                                fn(Builder $query, $month): Builder => $query->whereMonth('tanggal_faktur', $month),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                // Tables\Actions\Action::make('preview_pdfs')
                //     ->label('Preview PDF')
                //     ->icon('heroicon-o-eye')
                //     ->modalContent(fn(Transaction $record) => view('filament.actions.pdf-preview', ['record' => $record]))
                //     ->modalWidth('7xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('tanggal_faktur', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('company.name')
                    ->label('Perusahaan'),

                Infolists\Components\TextEntry::make('kode_kegiatan')
                    ->label('Kode Kegiatan'),

                Infolists\Components\TextEntry::make('title')
                    ->label('Judul'),

                Infolists\Components\TextEntry::make('tanggal_faktur')
                    ->label('Tanggal Faktur / SPJ')
                    ->date("d/m/Y"),

                Infolists\Components\TextEntry::make('notes')
                    ->label('Catatan'),

                Infolists\Components\RepeatableEntry::make('pdf_files')
                    ->label('File PDF')
                    ->schema([
                        Infolists\Components\TextEntry::make('pdf_files')
                            ->getStateUsing(fn($state) => basename($state))
                            ->url(fn($state) => asset('storage/' . $state))
                            ->openUrlInNewTab(),
                    ]),
            ]);
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
