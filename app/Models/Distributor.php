<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $table = 'distributors';

    protected $fillable = [
        'id_user',
        'nama_toko',
        'alamat',
        'no_hp',
    ];

     //Relasi ke user (distributor)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function stok()
    {
        return $this->hasMany(Stok::class, 'id_toko');
    }
    public function sales()
    {
        return $this->hasMany(Sales::class, 'id_toko');
    }
}
