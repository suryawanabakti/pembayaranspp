<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PembayaranPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Form Pembayaran';
    protected static ?int $navigationSort = -1;

    public static function canAccess(): bool
    {
        return auth()->user()->role === 'siswa';
    }


    protected static string $view = 'filament.pages.pembayaran-page';
}
