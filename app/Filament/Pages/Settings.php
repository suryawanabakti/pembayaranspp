<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    public static function canAccess(): bool
    {
        return request()->user()->role === 'admin';
    }
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Form Notifikasi';
    public ?array $data = [];
    // Tambahkan properti untuk menyimpan nilai form
    public ?string $tanggal = null;
    public ?string $jam = null;
    public function mount()
    {
        $setting = Setting::first();
        if ($setting) {
            $this->form->fill([
                'tanggal' => $setting->tanggal,
                'jam' => $setting->jam,
            ]);
        }
    }

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make('Pengaturan Jadwal')->schema([
                    TextInput::make('tanggal')->numeric()->required(),
                    TimePicker::make('jam')->required(),
                ])
            ])
            ->columns(3);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $setting = Setting::first();
        if (!$setting) {
            Setting::create($data);
        } else {
            $setting->update($data);
        }
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
}
