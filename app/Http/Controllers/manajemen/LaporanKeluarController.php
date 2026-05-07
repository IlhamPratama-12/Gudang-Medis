<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LaporanKeluarController extends Controller
{
    public function index()
    {
        // DATA REKAP STOK (dari tabel gudang_stok)
        $data = DB::table('gudang_stok')
            ->select(
                'kode_asal',
                'nama_alat_medis',
                'kategori',
                'jenis',
                'satuan',
                DB::raw('SUM(total_masuk) as total_masuk'),
                DB::raw('SUM(total_keluar) as total_keluar'),
                DB::raw('SUM(saldo_stok) as saldo_stok')
            )
            ->groupBy(
                'kode_asal',
                'nama_alat_medis',
                'kategori',
                'jenis',
                'satuan'
            )
            ->get();

        // SUMMARY
        $summary = [
            'total_item'   => $data->count(),
            'total_masuk'  => $data->sum('total_masuk'),
            'total_keluar' => $data->sum('total_keluar'),
            'total_saldo'  => $data->sum('saldo_stok'),
        ];

        // TOP 10 STOK KELUAR
        $topKeluar = $data->sortByDesc('total_keluar')->take(10)->values();

        return view('dashboard.manajemen.laporan_keluar', compact(
            'data',
            'summary',
            'topKeluar'
        ));
    }
}