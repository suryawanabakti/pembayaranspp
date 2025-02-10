<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $guarded = ['id'];
    public $table = 'siswa';
    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'id', 'user_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
