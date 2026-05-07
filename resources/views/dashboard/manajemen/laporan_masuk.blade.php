@extends('layouts.dashboard')

@section('title', 'Laporan Stok Masuk')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Laporan Stok Masuk
    </h1>
    <p class="text-sm text-gray-500">
        Ringkasan dan visualisasi stok barang masuk
    </p>
</div>

{{-- SUMMARY --}}
<div class="mb-6 w-full">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full px-6">

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <p class="text-sm text-gray-500">Total Item</p>
            <p class="text-2xl font-bold">
                {{ $summary['total_item'] }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <p class="text-sm text-gray-500">Total Masuk</p>
            <p class="text-2xl font-bold text-green-600">
                {{ $summary['total_masuk'] }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <p class="text-sm text-gray-500">Sisa Stok</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ $summary['total_saldo'] }}
            </p>
        </div>

    </div>

</div>

{{-- CHART --}}
<div class="bg-white p-4 rounded-xl shadow mb-6 w-full max-w-2xl">

    <h2 class="font-semibold mb-3 text-sm text-gray-700">
        Top 10 Barang Masuk
    </h2>

    <div class="h-56">
        <canvas id="chartMasuk"></canvas>
    </div>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl shadow overflow-x-auto">

    <table class="w-full text-sm">

        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3">Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Satuan</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Saldo</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($data as $item)
            <tr class="border-b">

                <td class="px-4 py-2">{{ $item->kode_asal }}</td>
                <td>{{ $item->nama_alat_medis }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->satuan }}</td>

                <td class="text-green-600 font-semibold">
                    {{ $item->total_masuk }}
                </td>

                <td class="text-red-600 font-semibold">
                    {{ $item->total_keluar }}
                </td>

                <td class="font-bold">
                    {{ $item->saldo_stok }}
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartMasuk');

const labels = {!! json_encode($topMasuk->pluck('kode_asal')) !!};
const dataMasuk = {!! json_encode($topMasuk->pluck('total_masuk')) !!};

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Masuk',
            data: dataMasuk,
            backgroundColor: 'rgba(34, 197, 94, 0.6)',
            borderRadius: 4,
            barThickness: 14
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // 🔥 penting biar ngikut height kecil
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                ticks: {
                    font: { size: 9 }
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    font: { size: 9 }
                }
            }
        }
    }
});
</script>

@endsection