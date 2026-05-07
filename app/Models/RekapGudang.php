<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapGudang extends Model
{
    protected $table = 'rekap_gudang';

    protected $primaryKey = 'kode_asal'; 

    public $incrementing = false; 

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'kode_asal',
        'nama_alat_medis',
        'jenis',
        'satuan',
        'total_stok',
        'jumlah_supplier',
        'avg_pemakaian',
        'safety_stock',
    ];
}