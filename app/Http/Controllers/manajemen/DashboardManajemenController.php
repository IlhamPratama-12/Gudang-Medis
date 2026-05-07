<?php

namespace App\Http\Controllers\Manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardManajemenController extends Controller
{
    public function index()
    {
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

        // =========================
        // SUMMARY DASHBOARD
        // =========================
        $summary = [
            'total_item'   => $data->count(),
            'total_masuk'  => $data->sum('total_masuk'),
            'total_keluar' => $data->sum('total_keluar'),
            'total_saldo'  => $data->sum('saldo_stok'),
        ];

        // =========================
        // STATUS STOK
        // =========================
        $status = [
            'aman' => $data->filter(fn($i) => $i->saldo_stok > $i->safety_stock)->count(),
            'rawan' => $data->filter(fn($i) =>
                $i->saldo_stok <= $i->safety_stock * 1.5 &&
                $i->saldo_stok > $i->safety_stock
            )->count(),
            'kritis' => $data->filter(fn($i) => $i->saldo_stok <= $i->safety_stock)->count(),
        ];

        // =========================
        // TOP DATA
        // =========================
        $topKeluar = $data->sortByDesc('total_keluar')->take(10)->values();
        $topMasuk  = $data->sortByDesc('total_masuk')->take(10)->values();

        // =========================
        // BARANG KRITIS
        // =========================
        $kritis = $data->filter(fn($i) => $i->saldo_stok <= $i->safety_stock)->take(10);

        // =========================
        // ALERT POPUP DATA
        // =========================
        $alertStok = $data->filter(fn($i) => $i->saldo_stok <= $i->safety_stock)->values();

        return view('dashboard.manajemen.dashboard', [
            'summary'    => $summary,
            'status'     => $status,
            'topKeluar'  => $topKeluar,
            'topMasuk'   => $topMasuk,
            'kritis'     => $kritis,
            'alertStok'  => $alertStok,
        ]);
    }
}