<?php

namespace App\Filament\Resources\UserRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Nama')->placeholder("Masukkan nama siswa"),
                TextInput::make('username')->label('NISN')->required()->unique(ignoreRecord: true)->placeholder("Masukkan NISN Siswa"),
                TextInput::make('email')->required()->unique(ignoreRecord: true)->placeholder("Masukkan Email Siswa"),
                TextInput::make('role')->required()->unique(ignoreRecord: true)->placeholder("siswa")->default('siswa')->hidden(),
                TextInput::make('password')->label('Password')->required()->unique(ignoreRecord: true)->placeholder("Masdukkan Password Siswa"),
                TextInput::make('nohp_orangtua')->required()->placeholder("Masukkan No WA Aktif Orang Tua"),
                Textarea::make('alamat')->required()->placeholder("Masukkan alamat siswa"),

            ]);
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = bcrypt('username');
        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('username')->label('NISN'),
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
