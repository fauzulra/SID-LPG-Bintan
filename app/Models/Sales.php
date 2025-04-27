<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'nomor_transaksi','id_penerima', 'id_toko', 'jumlah_barang', 'harga_satuan', 'total_harga'
    ];
    
    public function penerima()
    {   
        return $this->belongsTo(Reciepents::class, 'id_penerima');
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'id_toko');
    }
}
