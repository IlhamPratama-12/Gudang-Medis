@extends('layouts.dashboard')

@section('title', 'Edit Alat Medis')

@section('content')

<div class="mb-6 flex justify-between items-center">

    <h1 class="text-2xl font-bold">Edit Alat Medis</h1>

    <a href="{{ route('petugas.gudang') }}"
       class="bg-gray-500 text-white px-3 py-1 rounded text-sm">
        ← Kembali
    </a>

</div>

<form action="{{ route('alat.update', $alat->id) }}" method="POST"
      class="bg-white p-4 rounded shadow space-y-3">

    @csrf
    @method('PUT')

    {{-- NAMA ALAT --}}
    <input type="text" name="nama_alat"
        value="{{ $alat->nama_alat }}"
        class="w-full border p-2 rounded">

    {{-- JENIS BARANG --}}
    <select name="jenis_barang" class="w-full border p-2 rounded">
        <option value="Konsumable" {{ $alat->jenis_barang == 'Konsumable' ? 'selected' : '' }}>
            Konsumable
        </option>
        <option value="Non-Konsumable" {{ $alat->jenis_barang == 'Non-Konsumable' ? 'selected' : '' }}>
            Non Konsumable
        </option>
    </select>

    {{-- SATUAN --}}
    <select name="satuan" class="w-full border p-2 rounded" required>
        <option value="">-- Pilih Satuan --</option>

        <option value="pcs" {{ $alat->satuan == 'pcs' ? 'selected' : '' }}>pcs</option>
        <option value="box" {{ $alat->satuan == 'box' ? 'selected' : '' }}>box</option>
        <option value="unit" {{ $alat->satuan == 'unit' ? 'selected' : '' }}>unit</option>
        <option value="botol" {{ $alat->satuan == 'botol' ? 'selected' : '' }}>botol</option>
    </select>

    {{-- STOK (SIMPLE ANGKA) --}}
    <input type="number" name="stok"
        value="{{ $alat->stok }}"
        class="w-full border p-2 rounded">

    {{-- SAFETY STOCK --}}
    <input type="number" name="safety_stock"
        value="{{ $alat->safety_stock }}"
        class="w-full border p-2 rounded">

    {{-- STATUS --}}
    <select name="status" class="w-full border p-2 rounded">
        <option value="Baik" {{ $alat->status == 'Baik' ? 'selected' : '' }}>Baik</option>
        <option value="Rusak" {{ $alat->status == 'Rusak' ? 'selected' : '' }}>Rusak</option>
        <option value="Maintenance" {{ $alat->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
        <option value="Expired" {{ $alat->status == 'Expired' ? 'selected' : '' }}>Expired</option>
    </select>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection