<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $label = 'Perusahaan';

    protected static ?string $pluralLabel = 'Perusahaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Perusahaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_cs')
                    ->label('Nomor CS Sales')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_cs')
                    ->label('Nama CS Sales')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat')
                    ->rows(4)
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_cs')->label('Nama CS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_cs')->label('Nomor CS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat')->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('transaction_count')
                    ->label('Jumlah Faktur')
                    ->getStateUsing(fn(Company $record): int => $record->transactions()->count()),
                Tables\Columns\TextColumn::make('total_pdf_files')
                    ->label('Total File PDF')
                    ->getStateUsing(fn(Company $record): int => $record->total_pdf_files),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name')
                    ->label('Nama Perusahaan'),
                Infolists\Components\TextEntry::make('nomor_cs')
                    ->label('Nomor CS Sales'),
                Infolists\Components\TextEntry::make('nama_cs')
                    ->label('Nama CS Sales'),
                Infolists\Components\TextEntry::make('alamat')
                    ->label('Alamat'),
                Infolists\Components\TextEntry::make('transaction_count')
                    ->label('Jumlah Transaksi')
                    ->getStateUsing(fn(Company $record): int => $record->transactions()->count()),
                Infolists\Components\TextEntry::make('total_pdf_files')
                    ->label('Total File PDF')
                    ->getStateUsing(fn(Company $record): int => $record->total_pdf_files),
                Infolists\Components\TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'view' => Pages\ViewCompany::route('/{record}'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
