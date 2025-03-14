<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\Siswa;
use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\BillNotification;
use App\Services\Fonnte;
use Carbon\Carbon;

class SendBillNotification extends Command
{
    protected $signature = 'bill:notify';
    protected $description = 'Mengirim notifikasi tagihan setiap tanggal 12 jam 6 pagi';

    public function handle()
    {
        $today = Carbon::now()->day;

        $setting = Setting::first();
        if ($today == $setting->tanggal) {
            $users = User::all();

            foreach ($users as $user) {
                if ($user->nohp_orangtua) {
                    Fonnte::sendWa($user->nohp_orangtua, "Harap melakukan pembayaran SPP sebesar Rp. " . number_format($setting->jumlah_pembayaran, 0, ',', '.') . " sebelum tanggal $setting->tanggal setiap bulannya. Terima kasih.");
                }
            }

            $this->info('Notifikasi tagihan telah dikirim.');
        } else {
            $this->info('Hari ini bukan tanggal , tidak ada notifikasi.');
        }
    }
}
