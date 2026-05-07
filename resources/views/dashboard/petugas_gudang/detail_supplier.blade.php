@extends('layouts.dashboard')

@section('title', 'Detail Supplier')

@section('content')

<div class="mb-6 flex justify-between items-center">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Detail Supplier
        </h1>

        <p class="text-sm text-gray-500">
            Rincian stok berdasarkan supplier
        </p>
    </div>

    <a href="{{ route('petugas.gudang') }}"
       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">

        ← Kembali

    </a>

</div>

<div class="bg-white rounded-xl shadow p-5">

    <div class="overflow-x-auto">

        <table class="w-full text-sm border border-gray-200">

            <thead class="bg-gray-100 text-gray-700">

                <tr>
                    <th class="px-4 py-3 text-left">Kode</th>
                    <th class="px-4 py-3 text-left">Nama Alat</th>
                    <th class="px-4 py-3 text-left">Supplier</th>
                    <th class="px-4 py-3 text-left">Stok</th>
                    <th class="px-4 py-3 text-left">Satuan</th>
                </tr>

            </thead>

            <tbody>

                @foreach($alatMedis as $alat)

                <tr class="border-t">

                    <td class="px-4 py-3">
                        {{ $alat->kode_barang }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $alat->nama_alat_medis }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $alat->nama_supplier }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $alat->saldo_stok }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $alat->satuan }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection