<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Filament\Resources\SiswaResource\RelationManagers\TransactionRelationManager;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Services\Fonnte;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $pluralModelLabel = 'Data Siswa';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Siswa')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')->label('Nama')->required(),
                        TextInput::make('email')->unique()->label('Email')->unique(ignoreRecord: true)->required(),
                    ]),
                    Grid::make(2)->schema([
                        Select::make('kelas_id')->label('Kelas')->options(Kelas::all()->pluck('nama', 'id'))->required(),
                        Select::make('jurusan_id')->label('Jurusan')->options(Jurusan::all()->pluck('nama', 'id'))->required(),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('username')->label('NIS')->unique(ignoreRecord: true)->required(),
                        TextInput::make('nohp')->unique()->label('Nomor Handphone Siswa')->required(),
                    ]),
                    Textarea::make('alamat')->nullable()->required(),
                ]),
                Section::make('Data Orang Tua')->schema([
                    TextInput::make('nohp_orangtua')->unique()->label('Nomor Handphone Orang Tua')->required(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('user.name'),
                TextEntry::make('user.email'),
                TextEntry::make('user.username')->label("NIM"),
                TextEntry::make('nohp'),
                TextEntry::make('nohp_orangtua'),
                TextEntry::make('jurusan.nama'),
                TextEntry::make('kelas.nama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('user.name')->label('Nama'),
                TextInputColumn::make('user.username')->label('NIM'),
                // TextColumn::make('user.username')->label('NIM'),
                TextInputColumn::make('nohp_orangtua')->label('No.HP Orang tua'),
                TextColumn::make('kelas.nama'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('sendWA')
                        ->label('Send WA') // Label tombol
                        ->icon('heroicon-m-envelope') // Ikon email
                        ->requiresConfirmation() // Konfirmasi sebelum menjalankan aksi
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                Fonnte::sendWa($record->nohp_orangtua, "Harap melakukan pembayaran SPP");
                            }
                        })
                        ->deselectRecordsAfterCompletion(), // Hapus centang setelah aksi selesai
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TransactionRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'view' => Pages\ViewSiswa::route('/{record}'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
