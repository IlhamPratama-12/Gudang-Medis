@extends('layouts.dashboard')

@section('title', 'Data Stok Masuk')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Stok Masuk</h1>
    <p class="text-sm text-gray-500">Riwayat barang masuk gudang</p>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow p-5">

    {{-- FILTER (SUDAH FULL LARAVEL) --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-5 items-center">

        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama / kode barang..."
            class="border px-3 py-2 rounded-lg text-sm w-72">

        <select name="bulan" class="border px-3 py-2 rounded-lg text-sm">
            <option value="">Semua Bulan</option>
            @for($i=1;$i<=12;$i++)
                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select>

        <input type="number"
            name="tahun"
            value="{{ request('tahun') }}"
            placeholder="Tahun"
            class="border px-3 py-2 rounded-lg text-sm w-32">

        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">
            Filter
        </button>

        <a href="{{ route('stok.masuk') }}"
           class="bg-gray-200 px-4 py-2 rounded-lg text-sm">
            Reset
        </a>

        <a href="{{ route('stok.masuk.create') }}"
           class="ml-auto bg-green-500 text-white px-4 py-2 rounded-lg text-sm">
            + Tambah
        </a>

    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Supplier</th>
                </tr>
            </thead>

            <tbody>

                @forelse($stokMasuk as $item)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-4 py-2">
                        {{ $loop->iteration + ($stokMasuk->currentPage()-1)*$stokMasuk->perPage() }}
                    </td>

                    <td class="px-4 py-2">{{ $item->kode_barang }}</td>
                    <td class="px-4 py-2">{{ $item->nama_alat_medis }}</td>
                    <td class="px-4 py-2">{{ $item->kategori }}</td>
                    <td class="px-4 py-2">{{ $item->jenis }}</td>
                    <td class="px-4 py-2">{{ $item->tanggal_masuk }}</td>

                    <td class="px-4 py-2 text-blue-600 font-semibold">
                        {{ $item->jumlah_masuk }}
                    </td>

                    <td class="px-4 py-2">{{ $item->satuan }}</td>
                    <td class="px-4 py-2">{{ $item->supplier_vendor }}</td>

                </tr>

                @empty
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $stokMasuk->links() }}
    </div>

</div>

@endsection