<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChartTranksaksiPerBulan extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pembayaran Per Bulan';
    protected int | string | array $columnSpan = 'full'; // Tambahkan ini

    public static function canView(): bool
    {
        return Auth::user() && Auth::user()->role === 'admin';
    }
    protected function getData(): array
    {
        $transactions = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(harga) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Pembayaran',
                    'data' => $transactions->pluck('total')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                ],
            ],
            'labels' => $transactions->pluck('month')->map(fn($m) => date('F', mktime(0, 0, 0, $m, 1)))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
