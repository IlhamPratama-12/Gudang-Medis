@extends('layouts.dashboard')

@section('title', 'Tambah Stok Keluar')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-bold text-gray-800">
        Tambah Stok Keluar
    </h1>

    <p class="text-sm text-gray-500">
        Catat pengeluaran alat medis dari gudang
    </p>

</div>

@if (session('error'))
<div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow p-6">

    <form action="{{ route('stok.keluar.store') }}"
          method="POST"
          class="space-y-5">

        @csrf

        {{-- PILIH BARANG (SEARCHABLE) --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Pilih Barang
            </label>

            <select id="barangSelect"
                    name="kode_barang"
                    required
                    class="w-full border rounded-lg px-4 py-2 select2">

                <option value="">-- Cari / Pilih Barang --</option>

                @foreach($barang ?? [] as $item)

                <option
                    value="{{ $item->kode_barang }}"
                    data-nama="{{ $item->nama_alat_medis }}"
                    data-jenis="{{ $item->jenis }}"
                    data-satuan="{{ $item->satuan }}"
                >
                    {{ $item->kode_barang }} - {{ $item->nama_alat_medis }}
                </option>

                @endforeach

            </select>

        </div>

        {{-- NAMA --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nama Alat Medis
            </label>

            <input type="text"
                   id="nama"
                   name="nama_alat_medis"
                   readonly
                   class="w-full border rounded-lg px-4 py-2 bg-gray-100">
        </div>

        {{-- JENIS --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jenis
            </label>

            <input type="text"
                   id="jenis"
                   name="jenis"
                   readonly
                   class="w-full border rounded-lg px-4 py-2 bg-gray-100">
        </div>

        {{-- SATUAN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Satuan
            </label>

            <input type="text"
                   id="satuan"
                   name="satuan"
                   readonly
                   class="w-full border rounded-lg px-4 py-2 bg-gray-100">
        </div>

        {{-- UNIT TUJUAN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Unit Tujuan
            </label>

            <input type="text"
                   name="unit_tujuan"
                   required
                   placeholder="Contoh: ICU / IGD / Radiologi"
                   class="w-full border rounded-lg px-4 py-2">
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Keluar
            </label>

            <input type="date"
                   name="tanggal_keluar"
                   required
                   class="w-full border rounded-lg px-4 py-2">
        </div>

        {{-- JUMLAH --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jumlah Keluar
            </label>

            <input type="number"
                   name="jumlah_keluar"
                   required
                   min="1"
                   class="w-full border rounded-lg px-4 py-2">
        </div>

        {{-- KETERANGAN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Keterangan
            </label>

            <textarea name="keterangan"
                      rows="3"
                      class="w-full border rounded-lg px-4 py-2"
                      placeholder="Opsional"></textarea>
        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3 pt-3">

            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

                Simpan Keluar

            </button>

            <a href="{{ route('stok.keluar') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                Kembali

            </a>

        </div>

    </form>

</div>

{{-- ========================= --}}
{{-- SELECT2 CDN --}}
{{-- ========================= --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {

    // SELECT2 SEARCH
    $('.select2').select2({
        placeholder: "-- Cari / Pilih Barang --",
        width: '100%'
    });

    // AUTO FILL
    $('#barangSelect').on('change', function () {

        let selected = this.options[this.selectedIndex];

        $('#nama').val(selected.dataset.nama ?? '');
        $('#jenis').val(selected.dataset.jenis ?? '');
        $('#satuan').val(selected.dataset.satuan ?? '');

    });

});

</script>

@endsection