<?php

namespace App\Http\Controllers\petugas;

use App\Http\Controllers\Controller;
use App\Models\AlatMedis;
use Illuminate\Http\Request;

class AlatMedisController extends Controller
{
    public function index(Request $request)
    {
        // $alatMedis = AlatMedis::query()

        $query = AlatMedis::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_alat', 'like', '%' . $request->search . '%')
                ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_barang')) {
            $query->where('jenis_barang', $request->jenis_barang);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $alatMedis = $query->orderBy('id', 'desc')->get();

        return view('dashboard.petugas_gudang.index', compact('alatMedis'));
    }

    public function create()
    {
        return view('dashboard.petugas_gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required',
            'jenis_barang' => 'required',
            'satuan' => 'required',
            'stok' => 'required|integer',
            'safety_stock' => 'required|integer',
        ]);

        // AUTO KODE
        if ($request->jenis_barang == 'Konsumable') {
            $last = AlatMedis::where('kode_barang', 'LIKE', 'K%')
                ->orderByDesc('kode_barang')
                ->first();

            $number = $last ? (int)substr($last->kode_barang, 1) + 1 : 1;
            $kode = 'K' . str_pad($number, 3, '0', STR_PAD_LEFT);
        } else {
            $last = AlatMedis::where('kode_barang', 'LIKE', 'NK%')
                ->orderByDesc('kode_barang')
                ->first();

            $number = $last ? (int)substr($last->kode_barang, 2) + 1 : 1;
            $kode = 'NK' . str_pad($number, 3, '0', STR_PAD_LEFT);
        }

        AlatMedis::create([
            'kode_barang' => $kode,
            'nama_alat' => $request->nama_alat,
            'jenis_barang' => $request->jenis_barang,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'safety_stock' => $request->safety_stock,
            'status' => 'Baik',
        ]);

        return redirect()->route('petugas.gudang')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $alat = AlatMedis::findOrFail($id);
        return view('dashboard.petugas_gudang.edit', compact('alat'));
    }

    public function update(Request $request, $id)
    {
        $alat = AlatMedis::findOrFail($id);

        $alat->update([
            'nama_alat' => $request->nama_alat,
            'jenis_barang' => $request->jenis_barang,
            'satuan' => $request->satuan,
            'stok' => $request->stok,
            'safety_stock' => $request->safety_stock,
            'status' => $request->status ?? 'Baik',
        ]);

        return redirect()->route('petugas.gudang')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        AlatMedis::findOrFail($id)->delete();

        return redirect()->route('petugas.gudang')
            ->with('success', 'Data berhasil dihapus');
    }
}