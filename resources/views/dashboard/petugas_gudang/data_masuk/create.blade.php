@extends('layouts.dashboard')

@section('title', 'Tambah Stok Masuk')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-bold text-gray-800">
        Tambah Stok Masuk
    </h1>

    <p class="text-sm text-gray-500">
        Tambahkan data stok masuk alat medis
    </p>

</div>

@if ($errors->any())

<div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">

    <ul class="list-disc pl-5 text-sm">

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </ul>

</div>

@endif

<div class="bg-white rounded-2xl shadow p-6">

    <form action="{{ route('stok.masuk.store') }}"
          method="POST"
          class="space-y-5">

        @csrf

        {{-- PILIH BARANG --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Pilih Barang
            </label>

            <select id="barangSelect"
                    required
                    class="w-full border rounded-lg px-4 py-2">

                <option value="">
                    -- Pilih Barang --
                </option>

                @foreach($barang as $item)

                <option
                    value="{{ $item->kode_asal }}"
                    data-nama="{{ $item->nama_alat_medis }}"
                    data-jenis="{{ $item->jenis }}"
                    data-satuan="{{ $item->satuan }}"
                >

                    {{ $item->kode_asal }} - {{ $item->nama_alat_medis }}

                </option>

                @endforeach

            </select>

        </div>

        {{-- HIDDEN INPUT --}}
        <input type="hidden" name="kode_asal" id="kode_asal">

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

        {{-- SUPPLIER --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Supplier / Vendor
            </label>

            <input type="text"
                   name="supplier_vendor"
                   required
                   placeholder="Contoh: PT Kimia Farma"
                   class="w-full border rounded-lg px-4 py-2">

        </div>

        {{-- TANGGAL --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Tanggal Masuk
            </label>

            <input type="date"
                   name="tanggal_masuk"
                   required
                   class="w-full border rounded-lg px-4 py-2">

        </div>

        {{-- JUMLAH --}}
        <div>

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jumlah Masuk
            </label>

            <input type="number"
                   name="jumlah_masuk"
                   required
                   min="1"
                   class="w-full border rounded-lg px-4 py-2">

        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3 pt-3">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                Simpan

            </button>

            <a href="{{ route('stok.masuk') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                Kembali

            </a>

        </div>

    </form>

</div>

<script>

document.getElementById('barangSelect').addEventListener('change', function () {

    let selected = this.options[this.selectedIndex];

    document.getElementById('kode_asal').value =
        selected.value ?? '';

    document.getElementById('nama').value =
        selected.dataset.nama ?? '';

    document.getElementById('jenis').value =
        selected.dataset.jenis ?? '';

    document.getElementById('satuan').value =
        selected.dataset.satuan ?? '';
});

</script>

@endsection