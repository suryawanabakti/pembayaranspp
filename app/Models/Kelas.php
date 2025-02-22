<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    public $table = 'kelas';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
