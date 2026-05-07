<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatMedis extends Model
{
    protected $table = 'gudang_stok';

    protected $fillable = [
        'kode_barang',
        'kode_asal',
        'nama_alat_medis',
        'kategori',
        'jenis',
        'satuan',

        'total_masuk',
        'total_keluar',
        'saldo_stok',

        'avg_pemakaian',
        'safety_stock',

        'status_stok',
        'kondisi_fisik',

        'kode_supplier',
        'nama_supplier',
    ];

    // TAMBAH STOK MASUK
    public function tambahMasuk($qty)
    {
        $this->increment('total_masuk', $qty);
        $this->increment('saldo_stok', $qty);
    }

    // KURANG STOK KELUAR
    public function tambahKeluar($qty)
    {
        $this->increment('total_keluar', $qty);
        $this->decrement('saldo_stok', $qty);
    }
}