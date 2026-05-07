<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LaporanMasukController extends Controller
{
    public function index()
    {
        // DATA UTAMA (rekap stok)
        $data = DB::table('gudang_stok')
            ->select(
                'kode_asal',
                'nama_alat_medis',
                'kategori',
                'jenis',
                'satuan',
                DB::raw('SUM(total_masuk) as total_masuk'),
                DB::raw('SUM(total_keluar) as total_keluar'),
                DB::raw('SUM(saldo_stok) as saldo_stok'),
                DB::raw('AVG(avg_pemakaian) as avg_pemakaian'),
                DB::raw('AVG(safety_stock) as safety_stock')
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

        // TOP 10 BARANG PALING BANYAK MASUK (untuk chart)
        $topMasuk = $data->sortByDesc('total_masuk')->take(10);

        return view('dashboard.manajemen.laporan_masuk', compact(
            'data',
            'summary',
            'topMasuk'
        ));
    }
}