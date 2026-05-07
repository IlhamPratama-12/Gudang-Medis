<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    protected $table = 'stok_keluar';

    public $timestamps = false;

    protected $fillable = [
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