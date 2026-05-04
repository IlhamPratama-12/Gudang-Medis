<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    protected $table = 'stok_masuk';

    protected $fillable = [
        'no',
        'kode_barang',
        'nama_alat_medis',
        'kategori',
        'jenis',
        'tanggal_masuk',
        'bulan',
        'tahun',
        'jumlah_masuk',
        'satuan',
        'supplier_vendor',
    ];
}