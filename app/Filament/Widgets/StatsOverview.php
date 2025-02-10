<?php

namespace App\Filament\Widgets;

use App\Models\Siswa;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Siswa', Siswa::count()),
            Stat::make('Transaksi Sukses', Transaction::where('status', 'SUCCESS')->count()),
            Stat::make('Transaksi Pending', Transaction::where('status', 'PENDING')->count()),
        ];
    }
}
