@extends('layouts.dashboard')

@section('title', 'Tambah Alat Medis')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Tambah Alat Medis</h1>

    <a href="{{ route('petugas.gudang') }}"
       class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
        ← Kembali
    </a>
</div>

<form action="{{ route('alat.store') }}" method="POST"
      class="bg-white p-4 rounded shadow space-y-3">
    @csrf

    {{-- NAMA ALAT --}}
    <input type="text" name="nama_alat"
        placeholder="Nama Alat"
        class="w-full border p-2 rounded">

    {{-- JENIS BARANG --}}
    <select name="jenis_barang" class="w-full border p-2 rounded" required>
        <option value="">-- Jenis Barang --</option>
        <option value="Konsumable">Konsumable</option>
        <option value="Non-Konsumable">Non Konsumable</option>
    </select>

    {{-- SATUAN --}}
    <select name="satuan" class="w-full border p-2 rounded" required>
        <option value="">-- Pilih Satuan --</option>
        <option value="pcs">pcs</option>
        <option value="box">box</option>
        <option value="unit">unit</option>
        <option value="botol">botol</option>
    </select>

    {{-- STOK (SIMPLE ANGKA) --}}
    <input type="number" name="stok"
        placeholder="Stok"
        class="w-full border p-2 rounded">

    {{-- SAFETY STOCK --}}
    <input type="number" name="safety_stock"
        placeholder="Safety Stock"
        class="w-full border p-2 rounded">

    {{-- STATUS --}}
    <select name="status" class="w-full border p-2 rounded">
        <option value="Baik">Baik</option>
        <option value="Rusak">Rusak</option>
        <option value="Maintenance">Maintenance</option>
        <option value="Expired">Expired</option>
    </select>

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

@endsection