<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StokKeluar;

class StokKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = StokKeluar::query();

        // SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_alat_medis', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER TAHUN
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $stokKeluar = $query->orderBy('tanggal_keluar', 'desc')->get();

        return view('dashboard.petugas_gudang.data_keluar.index', compact('stokKeluar'));
    }

    public function create()
    {
        return view('dashboard.petugas_gudang.data_keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nama_alat_medis' => 'required',
            'jumlah_keluar' => 'required|integer',
            'tanggal_keluar' => 'required|date',
        ]);

        $tanggal = $request->tanggal_keluar;

        StokKeluar::create([
            'no' => $request->no,
            'kode_barang' => $request->kode_barang,
            'nama_alat_medis' => $request->nama_alat_medis,
            'kategori' => $request->kategori,
            'jenis' => $request->jenis,
            'tanggal_keluar' => $tanggal,
            'bulan' => date('m', strtotime($tanggal)),
            'tahun' => date('Y', strtotime($tanggal)),
            'jumlah_keluar' => $request->jumlah_keluar,
            'satuan' => $request->satuan,
            'unit_tujuan' => $request->unit_tujuan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('stok.keluar')
            ->with('success', 'Data stok keluar berhasil ditambahkan');
    }
}