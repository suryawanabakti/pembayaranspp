<?php

namespace App\Filament\Widgets;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected int | string | array $column = 2; // Tambahkan ini
    protected function getStats(): array
    {
        if (request()->user()->role === 'admin') {
            return [
                Stat::make('Jumlah Siswa', User::where('role', 'siswa')->count()),
                Stat::make('Jumlah Kelas', Kelas::count()),
                Stat::make('Total Pembayaran', Transaction::where('status', 'SUCCESS')->sum('harga')),
                // Stat::make('Transaksi Pending', Transaction::where('status', 'PENDING')->count()),
            ];
        }

        return [];
    }
}
