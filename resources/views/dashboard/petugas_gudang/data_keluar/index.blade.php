@extends('layouts.dashboard')

@section('title', 'Data Stok Keluar')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Stok Keluar</h1>
    <p class="text-sm text-gray-500">Riwayat barang keluar gudang</p>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow p-5">

    {{-- FILTER --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-5">

        {{-- SEARCH --}}
        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama / kode barang..."
            class="border px-3 py-2 rounded-lg text-sm w-72 focus:ring focus:outline-none">

        {{-- BULAN --}}
        <select name="bulan" class="border px-3 py-2 rounded-lg text-sm">
            <option value="">Semua Bulan</option>
            <option value="1" {{ request('bulan') == 1 ? 'selected' : '' }}>Januari</option>
            <option value="2" {{ request('bulan') == 2 ? 'selected' : '' }}>Februari</option>
            <option value="3" {{ request('bulan') == 3 ? 'selected' : '' }}>Maret</option>
            <option value="4" {{ request('bulan') == 4 ? 'selected' : '' }}>April</option>
            <option value="5" {{ request('bulan') == 5 ? 'selected' : '' }}>Mei</option>
            <option value="6" {{ request('bulan') == 6 ? 'selected' : '' }}>Juni</option>
            <option value="7" {{ request('bulan') == 7 ? 'selected' : '' }}>Juli</option>
            <option value="8" {{ request('bulan') == 8 ? 'selected' : '' }}>Agustus</option>
            <option value="9" {{ request('bulan') == 9 ? 'selected' : '' }}>September</option>
            <option value="10" {{ request('bulan') == 10 ? 'selected' : '' }}>Oktober</option>
            <option value="11" {{ request('bulan') == 11 ? 'selected' : '' }}>November</option>
            <option value="12" {{ request('bulan') == 12 ? 'selected' : '' }}>Desember</option>
        </select>

        {{-- TAHUN --}}
        <input type="number"
            name="tahun"
            value="{{ request('tahun') }}"
            placeholder="Tahun"
            class="border px-3 py-2 rounded-lg text-sm w-32">

        {{-- BUTTON FILTER --}}
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            Cari
        </button>

        {{-- RESET --}}
        <a href="{{ route('stok.keluar') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">
            Reset
        </a>

        {{-- TAMBAH --}}
        <a href="{{ route('stok.keluar.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm ml-auto">
            + Tambah
        </a>

    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Kode</th>
                    <th class="px-4 py-3 text-left">Nama Alat</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Jenis</th>
                    <th class="px-4 py-3 text-left">Tanggal Keluar</th>
                    <th class="px-4 py-3 text-left">Jumlah</th>
                    <th class="px-4 py-3 text-left">Satuan</th>
                    <th class="px-4 py-3 text-left">Unit Tujuan</th>
                    <th class="px-4 py-3 text-left">Keterangan</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @forelse($stokKeluar as $i => $item)
                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ $item->kode_barang }}</td>
                    <td class="px-4 py-3">{{ $item->nama_alat_medis }}</td>
                    <td class="px-4 py-3">{{ $item->kategori }}</td>
                    <td class="px-4 py-3">{{ $item->jenis }}</td>
                    <td class="px-4 py-3">{{ $item->tanggal_keluar }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                            {{ $item->jumlah_keluar }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $item->satuan }}</td>
                    <td class="px-4 py-3">{{ $item->unit_tujuan }}</td>
                    <td class="px-4 py-3">{{ $item->keterangan }}</td>

                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-6 text-gray-500">
                        Tidak ada data stok keluar
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection