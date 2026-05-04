<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    protected $table = 'stok_keluar';

    protected $fillable = [
        'no',
        'kode_barang',
        'nama_alat_medis',
        'kategori',
        'jenis',
        'tanggal_keluar',
        'bulan',
        'tahun',
        'jumlah_keluar',
        'satuan',
        'unit_tujuan',
        'keterangan',
    ];
}