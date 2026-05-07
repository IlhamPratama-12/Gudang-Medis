<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\AlatMedis;
use App\Models\RekapGudang;
use Illuminate\Http\Request;

class AlatMedisController extends Controller
{
    public function index(Request $request)
    {
        $query = RekapGudang::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_alat_medis', 'like', "%{$request->search}%")
                  ->orWhere('kode_asal', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('status_stok')) {
            $query->where('status_stok', $request->status_stok);
        }

        $alatMedis = $query->orderBy('kode_asal', 'asc')->get();

        return view('dashboard.petugas_gudang.index', compact('alatMedis'));
    }

    public function detail(Request $request)
    {
        $query = AlatMedis::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_alat_medis', 'like', "%{$request->search}%")
                  ->orWhere('kode_barang', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('status_stok')) {
            $query->where('status_stok', $request->status_stok);
        }

        $alatMedis = $query->orderBy('kode_barang', 'asc')->get();

        return view('dashboard.petugas_gudang.detail_supplier', compact('alatMedis'));
    }

    public function create()
    {
        return view('dashboard.petugas_gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat_medis' => 'required',
            'jenis'           => 'required',
            'satuan'          => 'required',
        ]);

        if ($request->jenis == 'Konsumable') {

            $last = RekapGudang::where('kode_asal', 'LIKE', 'K%')
                ->orderBy('kode_asal', 'desc')
                ->first();

            $number = $last ? (int) substr($last->kode_asal, 1) + 1 : 1;

            $kode = 'K' . str_pad($number, 3, '0', STR_PAD_LEFT);

        } else {

            $last = RekapGudang::where('kode_asal', 'LIKE', 'NK%')
                ->orderBy('kode_asal', 'desc')
                ->first();

            $number = $last ? (int) substr($last->kode_asal, 2) + 1 : 1;

            $kode = 'NK' . str_pad($number, 3, '0', STR_PAD_LEFT);
        }

        RekapGudang::create([
            'kode_asal'       => $kode,
            'nama_alat_medis' => $request->nama_alat_medis,
            'jenis'           => $request->jenis,
            'satuan'          => $request->satuan,

            'total_stok'      => 0,
            'jumlah_supplier' => 0,

            'avg_pemakaian'   => 0,
            'safety_stock'    => 0,

            'status_stok'     => 'Aman',
        ]);

        return redirect()->route('petugas.gudang')
            ->with('success', 'Data alat medis berhasil ditambahkan');
    }

    public function edit($id)
    {
        $alat = RekapGudang::findOrFail($id);
        return view('dashboard.petugas_gudang.edit', compact('alat'));
    }

    public function update(Request $request, $id)
    {
        $alat = RekapGudang::findOrFail($id);

        $alat->update([
            'nama_alat_medis' => $request->nama_alat_medis,
            'jenis'           => $request->jenis,
            'satuan'          => $request->satuan,
            'status_stok'     => $request->status_stok ?? 'Aman',
        ]);

        return redirect()->route('petugas.gudang')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        RekapGudang::findOrFail($id)->delete();

        return redirect()->route('petugas.gudang')
            ->with('success', 'Data berhasil dihapus');
    }
}