<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ListPembayaran extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Daftar Pembayaran';
    public static function canAccess(): bool
    {
        return auth()->user()->role === 'siswa';
    }

    protected static string $view = 'filament.pages.list-pembayaran';
}
