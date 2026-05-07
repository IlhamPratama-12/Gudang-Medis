@extends('layouts.dashboard')

@section('title', 'Dashboard Manajemen')

@section('content')

{{-- TITLE --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Dashboard Manajemen
    </h1>
    <p class="text-sm text-gray-500">
        Analisis stok gudang alat medis
    </p>
</div>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">

    <div class="bg-white p-4 rounded-xl shadow text-center">
        <p class="text-sm text-gray-500">Item</p>
        <p class="text-xl font-bold">{{ $summary['total_item'] }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center">
        <p class="text-sm text-gray-500">Masuk</p>
        <p class="text-xl font-bold text-green-600">{{ $summary['total_masuk'] }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center">
        <p class="text-sm text-gray-500">Keluar</p>
        <p class="text-xl font-bold text-red-600">{{ $summary['total_keluar'] }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow text-center">
        <p class="text-sm text-gray-500">Saldo</p>
        <p class="text-xl font-bold text-blue-600">{{ $summary['total_saldo'] }}</p>
    </div>

</div>

{{-- STATUS --}}
<div class="grid grid-cols-3 gap-4 mb-6 text-center">

    <div class="bg-green-100 p-4 rounded-xl">
        <p class="text-sm">Aman</p>
        <p class="text-2xl font-bold text-green-700">{{ $status['aman'] }}</p>
    </div>

    <div class="bg-yellow-100 p-4 rounded-xl">
        <p class="text-sm">Rawan</p>
        <p class="text-2xl font-bold text-yellow-700">{{ $status['rawan'] }}</p>
    </div>

    <div class="bg-red-100 p-4 rounded-xl">
        <p class="text-sm">Kritis</p>
        <p class="text-2xl font-bold text-red-700">{{ $status['kritis'] }}</p>
    </div>

</div>

{{-- CHARTS --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    <div class="bg-white p-4 rounded-xl shadow h-64">
        <h2 class="text-sm font-semibold mb-2">Top Keluar</h2>
        <canvas id="chartKeluar"></canvas>
    </div>

    <div class="bg-white p-4 rounded-xl shadow h-64">
        <h2 class="text-sm font-semibold mb-2">Top Masuk</h2>
        <canvas id="chartMasuk"></canvas>
    </div>

</div>

{{-- BARANG KRITIS --}}
<div class="bg-white p-4 rounded-xl shadow mb-6">

    <h2 class="font-semibold mb-3 text-red-600">Barang Kritis</h2>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-2 py-2">Kode</th>
                <th>Nama</th>
                <th>Saldo</th>
                <th>Safety</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kritis as $item)
            <tr class="border-b">
                <td class="px-2 py-1">{{ $item->kode_asal }}</td>
                <td>{{ $item->nama_alat_medis }}</td>
                <td class="text-red-600 font-bold">{{ $item->saldo_stok }}</td>
                <td>{{ $item->safety_stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@if($alertStok->count() > 0)

<div id="stokModal"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg p-6 rounded-xl shadow-lg">

        <h2 class="text-xl font-bold text-red-600 mb-3">
            ⚠️ Peringatan Stok Menipis
        </h2>

        <p class="text-sm text-gray-600 mb-4">
            Beberapa barang sudah mendekati atau melewati batas safety stock.
        </p>

        <div class="max-h-48 overflow-y-auto border rounded p-2 mb-4">

            @foreach($alertStok as $item)
                <div class="flex justify-between border-b py-1 text-sm">

                    <span>{{ $item->kode_asal }}</span>

                    <span class="text-red-600 font-semibold">
                        {{ $item->saldo_stok }} / {{ $item->safety_stock }}
                    </span>

                </div>
            @endforeach

        </div>

        <div class="flex justify-end gap-3">

            <a href="{{ route('petugas.gudang') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                Cek Ketersediaan Barang
            </a>

            <button onclick="closeModal()"
                    class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm">
                Tutup
            </button>

        </div>

    </div>

</div>

@endif

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labelsKeluar = {!! json_encode($topKeluar->pluck('kode_asal')) !!};
const dataKeluar = {!! json_encode($topKeluar->pluck('total_keluar')) !!};

new Chart(document.getElementById('chartKeluar'), {
    type: 'bar',
    data: {
        labels: labelsKeluar,
        datasets: [{
            data: dataKeluar,
            backgroundColor: 'rgba(239, 68, 68, 0.6)',
            barThickness: 10
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { font: { size: 9 } } },
            y: { ticks: { font: { size: 9 } } }
        }
    }
});

const labelsMasuk = {!! json_encode($topMasuk->pluck('kode_asal')) !!};
const dataMasuk = {!! json_encode($topMasuk->pluck('total_masuk')) !!};

new Chart(document.getElementById('chartMasuk'), {
    type: 'bar',
    data: {
        labels: labelsMasuk,
        datasets: [{
            data: dataMasuk,
            backgroundColor: 'rgba(34, 197, 94, 0.6)',
            barThickness: 10
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { font: { size: 9 } } },
            y: { ticks: { font: { size: 9 } } }
        }
    }
});

function closeModal() {
document.getElementById('stokModal').style.display = 'none';
}

</script>



@endsection