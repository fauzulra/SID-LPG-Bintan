<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';

    protected $fillable = ['id_toko', 'jumlah_barang', 'tanggal_masuk'];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id_toko');
    }
}
