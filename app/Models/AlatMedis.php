<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatMedis extends Model
{
    protected $table = 'alat_medis';

    protected $fillable = [
        'kode_barang',
        'nama_alat',
        'jenis_barang',
        'satuan',
        'stok',
        'safety_stock',
        'status',
    ];
}