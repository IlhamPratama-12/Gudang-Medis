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
    <div class="flex flex-wrap gap-3 mb-5 items-center">

        {{-- SEARCH --}}
        <input type="text"
            id="searchInput"
            placeholder="Cari nama / kode barang..."
            class="border px-3 py-2 rounded-lg text-sm w-72 focus:ring focus:outline-none">

        {{-- BULAN --}}
        <select id="filterBulan"
            class="border px-3 py-2 rounded-lg text-sm">

            <option value="">Semua Bulan</option>
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>

        </select>

        {{-- TAHUN --}}
        <input type="number"
            id="filterTahun"
            placeholder="Tahun"
            class="border px-3 py-2 rounded-lg text-sm w-32">

        {{-- TAMBAH --}}
        <a href="{{ route('stok.keluar.create') }}"
           class="ml-auto bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
            + Tambah
        </a>

    </div>

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

            <tbody id="tableBody" class="text-gray-700">

                @forelse($stokKeluar as $i => $item)

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3">
                        {{ $i + 1 }}
                    </td>

                    <td class="px-4 py-3 font-medium kode">
                        {{ $item->kode_barang }}
                    </td>

                    <td class="px-4 py-3 nama">
                        {{ $item->nama_alat_medis }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->kategori }}
                    </td>

                    <td class="px-4 py-3 jenis">
                        {{ $item->jenis }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->tanggal_keluar }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                            {{ $item->jumlah_keluar }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->satuan }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->unit_tujuan }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->keterangan }}
                    </td>

                    {{-- HIDDEN FILTER --}}
                    <td class="hidden bulan">
                        {{ $item->bulan }}
                    </td>

                    <td class="hidden tahun">
                        {{ $item->tahun }}
                    </td>

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

{{-- REALTIME FILTER --}}
<script>

function filterTable() {

    let search = document.getElementById('searchInput').value.toLowerCase();
    let bulan = document.getElementById('filterBulan').value;
    let tahun = document.getElementById('filterTahun').value;

    let rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(row => {

        let nama = row.querySelector('.nama')?.innerText.toLowerCase() || '';
        let kode = row.querySelector('.kode')?.innerText.toLowerCase() || '';
        let bulanRow = row.querySelector('.bulan')?.innerText || '';
        let tahunRow = row.querySelector('.tahun')?.innerText || '';

        let matchSearch = nama.includes(search) || kode.includes(search);
        let matchBulan = bulan === '' || bulanRow === bulan;
        let matchTahun = tahun === '' || tahunRow === tahun;

        row.style.display =
            (matchSearch && matchBulan && matchTahun)
            ? ''
            : 'none';
    });
}

document.getElementById('searchInput')
    .addEventListener('input', filterTable);

document.getElementById('filterBulan')
    .addEventListener('change', filterTable);

document.getElementById('filterTahun')
    .addEventListener('input', filterTable);

</script>

@endsection