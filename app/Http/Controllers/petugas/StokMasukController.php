<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StokMasuk;

class StokMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = StokMasuk::query();

        // SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_alat_medis', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER BULAN
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // FILTER TAHUN
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $stokMasuk = $query->orderBy('tanggal_masuk', 'desc')->get();

        return view('dashboard.petugas_gudang.data_masuk.index', compact('stokMasuk'));
    }
}