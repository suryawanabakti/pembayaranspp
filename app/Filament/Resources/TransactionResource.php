<?php

namespace App\Filament\Resources;

use App\Exports\TransactionExport;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Livewire\ChartTranksaksiPerBulan;
use App\Models\Kelas;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?string $pluralModelLabel = 'Laporan';
    protected static ?string $modelLabel = 'Laporan';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->label('Nama Siswa')->options(User::where('role', 'siswa')->pluck('name', 'id'))->required(),
                Select::make('bulan')->options([
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ]),
                Select::make('kelas_id')->label('Kelas')->options(Kelas::all()->pluck('nama', 'id'))->required(),
                Select::make('status')->options([
                    "PENDING" => "PENDING",
                    "SUCCESS" => "SUCCESS",
                    "FAILED" => "FAILED",
                ])->default('SUCCESS'),
                TextInput::make('harga')->default(25000)->numeric(),
            ]);
    }

    public static function canAccess(): bool
    {
        return request()->user()->role === 'admin' || request()->user()->role === 'kepala';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Transaction::orderBy('created_at', 'DESC'))
            ->headerActions([
                Action::make('export_pdf')
                    ->label('Export PDF')
                    ->color('success')
                    ->url(fn() => route('pembayaran.pdf'), true)
            ])
            ->columns([
                TextColumn::make('created_at')->label('Tanggal & Waktu'),
                TextColumn::make('user.name')->label('Nama'),
                TextColumn::make('user.kelas.nama')->label('Kelas'),

                TextColumn::make('bulan')
                    ->label("Bulan")
                    ->formatStateUsing(fn($state) => [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ][$state] ?? 'Tidak Valid'),
                TextColumn::make('harga')->label('Jumlah Pembayaran')->numeric(),
                TextColumn::make('status')->searchable()->sortable()->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'failed' => 'Failed',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
