<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Setting;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function pdf()
    {
        $data = Transaction::all();
        $pdf = Pdf::loadView('pembayaran.pdf', compact('data'));
        return $pdf->stream();
    }

    public function index()
    {

        if (!auth()->user()->siswa) {
            return redirect('/admin');
        }
        $transactions = Transaction::orderBy('created_at', 'DESC')->where('user_id', auth()->user()->id)->get();
        return view('pembayaran.index', compact('transactions'));
    }

    public function create()
    {
        if (auth()->user()->role == 'admin') {
            return redirect('/admin');
        }
        $kelas = Kelas::where('jurusan_id', auth()->user()->siswa->jurusan_id)->get();
        return view('pembayaran.create', ["kelas" => $kelas]);
    }

    public function checkout(Request $request)
    {
        // Validasi input
        if (auth()->user()->role == 'admin') {
            return redirect('/admin');
        }

        $request->validate([
            'kelas' => 'required',
            'bulan' => 'required',
        ]);

        // Simpan pembayaran ke database (opsional)

        $time = "INV-" . time();
        $setting = Setting::first();
        $pembayaran = Transaction::create([
            'user_id' => auth()->user()->id,
            'order_id' => $time,
            'kelas_id' => $request->kelas,
            'bulan' => $request->bulan,
            'status' => 'PENDING',
            'harga' => $setting->jumlah_pembayaran ?? 250000,
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Buat transaksi dengan Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $time,
                'gross_amount' => $pembayaran->harga,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('pembayaran.checkout', compact('snapToken', 'pembayaran'));
        } catch (\Exception $e) {
            return $e;
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $pembayaran = Transaction::where('order_ir', $request->order_id)->first();
            if ($pembayaran) {
                $pembayaran->status = $request->transaction_status;
                $pembayaran->save();
            }
        }
    }
}
