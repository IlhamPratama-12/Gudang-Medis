@extends('layouts.dashboard')

@section('title', 'Data Alat Medis')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Alat Medis</h1>
    <p class="text-sm text-gray-500">Kelola data alat medis dengan lebih mudah</p>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-4 border border-green-200">
        {{ session('success') }}
    </div>
@endif

{{-- CARD WRAPPER --}}
<div class="bg-white rounded-2xl shadow-md border border-gray-100 p-5">

    {{-- FILTER BAR --}}
    <div class="flex flex-wrap gap-3 mb-5 items-center">

        <input type="text"
            id="searchInput"
            placeholder="🔍 Cari nama / kode..."
            class="border border-gray-200 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 px-4 py-2 rounded-lg text-sm w-full md:w-64">

        <select id="filterJenis"
            class="border border-gray-200 px-3 py-2 rounded-lg text-sm">
            <option value="">Semua Jenis</option>
            <option value="Konsumable">Konsumable</option>
            <option value="Non-Konsumable">Non Konsumable</option>
        </select>

        <select id="filterStatus"
            class="border border-gray-200 px-3 py-2 rounded-lg text-sm">
            <option value="">Semua Status</option>
            <option value="Baik">Baik</option>
            <option value="Rusak">Rusak</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Expired">Expired</option>
        </select>

        <a href="{{ route('alat.create') }}"
           class="ml-auto bg-blue-600 hover:bg-blue-700 transition text-white px-4 py-2 rounded-lg text-sm shadow">
            + Tambah Data
        </a>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto rounded-lg border border-gray-100">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider">
                <tbody id="tableBody" class="divide-y divide-gray-100">

                @forelse($alatMedis as $i => $alat)

                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3">
                        {{ $i + 1 }}
                    </td>

                    <td class="px-4 py-3 kode">
                        {{ $alat->kode_asal }}
                    </td>

                    <td class="px-4 py-3 nama font-medium">
                        {{ $alat->nama_alat_medis }}
                    </td>

                    <td class="px-4 py-3 jenis">
                        {{ $alat->jenis }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                            {{ $alat->total_stok }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        {{ $alat->jumlah_supplier }} Supplier
                    </td>

                    <td class="px-4 py-3">
                        {{ $alat->satuan }}
                    </td>

                    <td class="px-4 py-3">

                        <a href="{{ route('petugas.gudang.detail', $alat->kode_asal) }}"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-xs">

                            Detail Supplier

                        </a>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="8"
                        class="text-center py-10 text-gray-400">

                        Tidak ada data

                    </td>
                </tr>

                @endforelse

                </tbody>
            </thead>

            <tbody id="tableBody" class="divide-y divide-gray-100">

                @forelse($alatMedis as $i => $alat)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    
                    <td class="px-4 py-3 kode text-gray-600">
                        {{ $alat->kode_barang }}
                    </td>

                    <td class="px-4 py-3 font-medium text-gray-800 nama">
                        {{ $alat->nama_alat_medis }}
                    </td>

                    <td class="px-4 py-3 jenis">
                        {{ $alat->jenis }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $alat->saldo_stok }}
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $alat->satuan }}
                    </td>

                    
                    {{-- STATUS BADGE --}}
                    <td class="px-4 py-3 status">
                        @php
                            $status = strtolower($alat->status);
                            @endphp

                            <span class="px-2 py-1 text-xs rounded-full font-medium
                            @if($status == 'baik') bg-green-100 text-green-700
                            @elseif($status == 'rusak') bg-red-100 text-red-700
                            @elseif($status == 'maintenance') bg-yellow-100 text-yellow-700
                            @elseif($status == 'expired') bg-gray-200 text-gray-700
                            @else bg-blue-100 text-blue-700
                            @endif
                            ">
                            {{ $alat->status_stok }}
                            </span>
                            </td>


                    <td class="px-4 py-3">
                        {{ $alat->nama_supplier }}
                    </td>

                    <td class="px-4 py-3">
                        <a href="{{ route('petugas.gudang.detail') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-xs">
                            Detail
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-10 text-gray-400">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>
    </div>
</div>

{{-- SCRIPT TETAP (tidak diubah) --}}
<script>
function filterTable() {
    let search = document.getElementById('searchInput').value.toLowerCase();
    let jenis = document.getElementById('filterJenis').value.toLowerCase();
    let status = document.getElementById('filterStatus').value.toLowerCase();

    let rows = document.querySelectorAll('#tableBody tr');

    rows.forEach(row => {

        let nama = row.querySelector('.nama')?.innerText.toLowerCase() || '';
        let kode = row.querySelector('.kode')?.innerText.toLowerCase() || '';
        let jenisRow = row.querySelector('.jenis')?.innerText.toLowerCase() || '';
        let statusRow = row.querySelector('.status')?.innerText.toLowerCase() || '';

        let matchSearch = nama.includes(search) || kode.includes(search);
        let matchJenis = jenis === '' || jenisRow === jenis;
        let matchStatus = status === '' || statusRow === status;

        row.style.display = (matchSearch && matchJenis && matchStatus) ? '' : 'none';
    });
}

document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('filterJenis').addEventListener('change', filterTable);
document.getElementById('filterStatus').addEventListener('change', filterTable);
</script>

@endsection