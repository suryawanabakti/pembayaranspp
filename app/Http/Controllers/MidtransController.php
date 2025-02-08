<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\Fonnte;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function success(Request $request)
    {

        Fonnte::sendWa(auth()->user()->siswa->nohp_orangtua, "Assalamualaikum warahmatullahi wabarakatuh \nSelamat! Pembayaran SPP untuk Kelas 2 Semester 2 dan biaya formal telah berhasil diproses. Terima kasih atas kepercayaannya. 🌟");

        Transaction::where('id', $request->order_id)->update([
            'status' => "SUCCESS"
        ]);

        return redirect('/pembayaran');
    }
}
