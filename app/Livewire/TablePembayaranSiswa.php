<?php

namespace App\Livewire;

use App\Models\Transaction;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TablePembayaranSiswa extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::where('user_id', request()->user()->id)->orderBy('created_at', 'DESC')
            )
            ->columns([
                TextColumn::make('created_at'),
                TextColumn::make('user.name'),
                TextColumn::make('user.username'),
                TextColumn::make('user.kelas.nama'),
                TextColumn::make('harga'),
                TextColumn::make('bulan'),
                TextColumn::make('status'),
            ]);
    }
}
