<?php

namespace App\Filament\Pages;

use App\Models\Kelas;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Redirect;

class BuatLaporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.buat-laporan';
    public $user_id = "";
    public $bulan = "";
    public $kelas_id = "";
    public $status = "";
    public $harga = "";
    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make('Form Buat Laporan')->schema([
                    Select::make('user_id')->label('Nama Siswa')->options(User::where('role', 'siswa')->pluck('name', 'id'))->required()->searchable(),
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
                    ])->searchable(),
                    Select::make('kelas_id')->label('Kelas')->options(Kelas::all()->pluck('nama', 'id'))->required()->searchable(),
                    Radio::make('status')->options([
                        "PENDING" => "PENDING",
                        "SUCCESS" => "SUCCESS",
                        "FAILED" => "FAILED",
                    ])->default('SUCCESS')->inline()->required(),
                    TextInput::make('harga')->default(25000)->numeric()->required(),
                ])
            ])
            ->columns(3);
    }

    public function save(): void
    {

        $data = $this->form->getState();

        Transaction::create($data);
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
        Redirect::to("/admin/transactions");
    }
}
