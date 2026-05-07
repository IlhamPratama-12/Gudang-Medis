<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StokMasuk;
use App\Models\AlatMedis;
use App\Models\RekapGudang;
use Illuminate\Support\Facades\DB;

class StokMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = StokMasuk::query();

        // SEARCH GLOBAL
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_alat_medis', 'like', "%{$request->search}%")
                  ->orWhere('kode_barang', 'like', "%{$request->search}%");
            });
        }

        // FILTER BULAN
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
        }

        // FILTER TAHUN
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        $stokMasuk = $query
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString(); // penting biar filter tidak hilang

        return view('dashboard.petugas_gudang.data_masuk.index', compact('stokMasuk'));
    }

    public function create()
    {
        $barang = RekapGudang::orderBy('nama_alat_medis', 'asc')->get();

        return view('dashboard.petugas_gudang.data_masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_asal'       => 'required',
            'nama_alat_medis' => 'required',
            'jenis'           => 'required',
            'tanggal_masuk'   => 'required',
            'jumlah_masuk'    => 'required|integer',
            'satuan'          => 'required',
            'supplier_vendor' => 'required',
        ]);

        DB::transaction(function () use ($request) {

            // =====================
            // KODE SUPPLIER
            // =====================
            $supplier = strtoupper($request->supplier_vendor);

            $kodeSupplier = collect(explode(' ', $supplier))
                ->map(function ($word) {
                    $word = trim($word);

                    if (in_array($word, ['PT','CV','UD','TBK'])) {
                        return '';
                    }

                    return substr($word, 0, 1);
                })
                ->implode('');

            $kodeSupplier = strtoupper($kodeSupplier);

            // =====================
            // KODE BARANG
            // =====================
            $kodeBarang = $request->kode_asal . '-' . $kodeSupplier;

            // =====================
            // SIMPAN STOK MASUK
            // =====================
            StokMasuk::create([
                'kode_barang'     => $kodeBarang,
                'nama_alat_medis' => $request->nama_alat_medis,
                'jenis'           => $request->jenis,
                'tanggal_masuk'   => $request->tanggal_masuk,
                'bulan'           => date('F Y', strtotime($request->tanggal_masuk)),
                'tahun'           => date('Y', strtotime($request->tanggal_masuk)),
                'jumlah_masuk'    => $request->jumlah_masuk,
                'satuan'          => $request->satuan,
                'supplier_vendor' => $request->supplier_vendor,
            ]);

            // =====================
            // UPDATE GUDANG STOK
            // =====================
            $alat = AlatMedis::where('kode_barang', $kodeBarang)->first();

            if ($alat) {
                $alat->increment('total_masuk', $request->jumlah_masuk);
                $alat->increment('saldo_stok', $request->jumlah_masuk);
            } else {
                AlatMedis::create([
                    'kode_barang'     => $kodeBarang,
                    'kode_asal'       => $request->kode_asal,
                    'nama_alat_medis' => $request->nama_alat_medis,
                    'jenis'           => $request->jenis,
                    'satuan'          => $request->satuan,
                    'total_masuk'     => $request->jumlah_masuk,
                    'total_keluar'    => 0,
                    'saldo_stok'      => $request->jumlah_masuk,
                    'avg_pemakaian'   => 0,
                    'safety_stock'    => 0,
                    'status_stok'     => 'Aman',
                    'kondisi_fisik'   => 'Baik',
                    'kode_supplier'   => $kodeSupplier,
                    'nama_supplier'   => $request->supplier_vendor,
                ]);
            }

            // =====================
            // UPDATE REKAP GUDANG (AMAN)
            // =====================
            $rekap = RekapGudang::where('kode_asal', $request->kode_asal)->first();

            if ($rekap) {

                $rekap->increment('total_stok', $request->jumlah_masuk);

                $rekap->jumlah_supplier = AlatMedis::where('kode_asal', $request->kode_asal)->count();

                $rekap->save();

            } else {
                // OPTIONAL: kalau belum ada rekap, bisa create
                RekapGudang::create([
                    'kode_asal' => $request->kode_asal,
                    'nama_alat_medis' => $request->nama_alat_medis,
                    'jenis' => $request->jenis,
                    'satuan' => $request->satuan,
                    'total_stok' => $request->jumlah_masuk,
                    'jumlah_supplier' => 1,
                    'avg_pemakaian' => 0,
                    'safety_stock' => 0,
                ]);
            }
        });

        return redirect()->route('stok.masuk')
            ->with('success', 'Stok masuk berhasil ditambahkan');
    }
}