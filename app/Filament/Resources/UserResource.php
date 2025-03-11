<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRelationManagerResource\RelationManagers\UsersRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Kelas;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $pluralModelLabel  = 'Siswa';
    protected static ?string $modelLabel  = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Nama')->placeholder("Masukkan nama siswa"),
                TextInput::make('username')->label('NISN')->required()->unique(ignoreRecord: true)->placeholder("Masukkan NISN Siswa"),
                TextInput::make('email')->required()->unique(ignoreRecord: true)->placeholder("Masukkan Email Siswa"),
                TextInput::make('nohp_orangtua')->required()->placeholder("Masukkan No WA Aktif Orang Tua"),
                Textarea::make('alamat')->required()->placeholder("Masukkan alamat siswa"),
                Grid::make(2)->schema([
                    Select::make('jurusan')
                        ->options([
                            "Administrasi Perkantoran" => "Administrasi Perkantoran",
                            "Teknik Komputer Jaringan" => "Teknik Komputer Jaringan"
                        ])
                        ->reactive() // Membuat jurusan menjadi reaktif
                        ->afterStateUpdated(fn(callable $set) => $set('kelas_id', null)), // Reset kelas saat jurusan berubah

                    Select::make('kelas_id')
                        ->label('Kelas')
                        ->options(
                            fn(callable $get) =>
                            \App\Models\Kelas::where('jurusan', $get('jurusan'))->pluck('nama', 'id')
                        )
                        ->reactive() // Membuat kelas otomatis berubah saat jurusan berubah
                        ->live() // Agar langsung diperbarui tanpa reload
                ])
            ]);
    }
    public static function canAccess(): bool
    {
        return request()->user()->role === 'admin';
    }
    public static function table(Table $table): Table
    {
        return $table
            ->query(User::where('role', 'siswa'))
            ->columns([
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('username')->label('NISN')->searchable(),
                TextColumn::make('kelas.nama')->label('Kelas')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
