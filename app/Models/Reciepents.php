<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reciepents extends Model
{
    use HasFactory;

    protected $table = 'reciepents';

    protected $fillable
    = [
        'jenis_pengguna',
        'nama',
        'nik',
        'alamat',
        'no_hp',
        'foto_ktp',
        'nama_usaha',
        'nib',
        'foto_usaha',
    ];

    public function sales()
    {
        return $this->hasMany(Sales::class, 'id_penerima');
    }



}