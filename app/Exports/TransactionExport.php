<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Transaction::all()->map(function ($data) {
            return [
                "tanggal" => $data->created_at->format('Y-m-d'),
                "nama" => $data->user->name,
                "kelas" => $data->user->kelas->name,
                "bulan" => $data->bulan,
                "harga" => $data->harga
            ];
        });
    }

    public function headings(): array
    {
        return ["TANGGAL", "NAMA", "KELAS", "BULAN", "HARGA"];
    }
}
