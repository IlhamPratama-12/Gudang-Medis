<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StokKeluar;
use App\Models\AlatMedis;
use App\Models\RekapGudang;
use Illuminate\Support\Facades\DB;

class StokKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = StokKeluar::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_alat_medis', 'like', "%{$request->search}%")
                  ->orWhere('kode_barang', 'like', "%{$request->search}%");
            });
        }

        $stokKeluar = $query->orderByDesc('tanggal_keluar')->get();

        return view('dashboard.petugas_gudang.data_keluar.index', compact('stokKeluar'));
    }

    public function create()
    {
        $barang = AlatMedis::orderBy('nama_alat_medis', 'asc')->get();

        return view('dashboard.petugas_gudang.data_keluar.create', compact('barang'));
    }

    public function store(Request $request)
{
    $request->validate([
        'kode_barang'     => 'required',
        'nama_alat_medis' => 'required',
        'jenis'           => 'required',
        'tanggal_keluar'  => 'required',
        'jumlah_keluar'   => 'required|integer|min:1',
        'satuan'          => 'required',
        'unit_tujuan'     => 'nullable',
        'keterangan'      => 'nullable',
    ]);

    try {

        DB::transaction(function () use ($request) {

            // =====================
            // AMBIL DARI GUDANG STOK
            // =====================
            $alat = AlatMedis::where('kode_barang', $request->kode_barang)->first();

            if (!$alat) {
                throw new \Exception("Barang tidak ditemukan di gudang");
            }

            // =====================
            // CEK STOK
            // =====================
            if ($alat->saldo_stok < $request->jumlah_keluar) {
                throw new \Exception("Stok tidak mencukupi (stok tersedia: {$alat->saldo_stok})");
            }

            // =====================
            // SIMPAN STOK KELUAR
            // =====================
            StokKeluar::create([
                'kode_barang'     => $alat->kode_barang,
                'nama_alat_medis' => $request->nama_alat_medis,
                'jenis'           => $request->jenis,
                'tanggal_keluar'  => $request->tanggal_keluar,
                'bulan'           => date('F Y', strtotime($request->tanggal_keluar)),
                'tahun'           => date('Y', strtotime($request->tanggal_keluar)),
                'jumlah_keluar'   => $request->jumlah_keluar,
                'satuan'          => $request->satuan,
                'unit_tujuan'     => $request->unit_tujuan,
                'keterangan'      => $request->keterangan,
            ]);

            // =====================
            // UPDATE GUDANG STOK (DETAIL)
            // =====================
            $alat->tambahKeluar($request->jumlah_keluar);

            // =====================
            // UPDATE REKAP GUDANG (INI YANG BENAR)
            // =====================
            $rekap = RekapGudang::where('kode_asal', $alat->kode_asal)->first();

            if ($rekap) {

                $rekap->decrement('total_stok', $request->jumlah_keluar);

            } else {

                // fallback kalau data belum sinkron
                RekapGudang::create([
                    'kode_asal'        => $alat->kode_asal,
                    'nama_alat_medis'  => $alat->nama_alat_medis,
                    'jenis'            => $alat->jenis,
                    'satuan'           => $alat->satuan,
                    'total_stok'       => max(0, $alat->saldo_stok - $request->jumlah_keluar),
                    'jumlah_supplier'  => 1,
                    'avg_pemakaian'    => 0,
                    'safety_stock'     => 0,
                ]);
            }
        });

        return redirect()->route('stok.keluar')
            ->with('success', 'Stok keluar berhasil ditambahkan');

    } catch (\Exception $e) {

        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}
}