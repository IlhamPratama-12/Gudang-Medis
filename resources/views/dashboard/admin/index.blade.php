@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold text-white">Dashboard Admin</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-800 p-4 rounded-xl text-white">
            <p class="text-sm text-gray-400">Profile Views</p>
            <h2 class="text-xl font-bold">112,000</h2>
        </div>

        <div class="bg-gray-800 p-4 rounded-xl text-white">
            <p class="text-sm text-gray-400">Followers</p>
            <h2 class="text-xl font-bold">183,000</h2>
        </div>

        <div class="bg-gray-800 p-4 rounded-xl text-white">
            <p class="text-sm text-gray-400">Following</p>
            <h2 class="text-xl font-bold">80,000</h2>
        </div>

        <div class="bg-gray-800 p-4 rounded-xl text-white">
            <p class="text-sm text-gray-400">Saved Post</p>
            <h2 class="text-xl font-bold">112</h2>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-gray-800 p-6 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-white">Profile Visit</h2>
            <span class="text-sm text-gray-400">Monthly</span>
        </div>

        <canvas id="profileChart" height="100"></canvas>
    </div>

</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('profileChart');

    // 🔥 FIX: pastikan canvas ada
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                data: [40, 60, 80, 70, 50, 90, 100, 75, 65, 95, 110, 85],
                backgroundColor: '#6366F1', // lebih soft (mirip gambar)
                borderRadius: 8,
                borderSkipped: false,
                barPercentage: 0.6,
                categoryPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false // 🔥 biar clean kayak gambar
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#374151',
                    borderWidth: 1
                }
            },

            scales: {
                x: {
                    ticks: {
                        color: '#9CA3AF'
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    ticks: {
                        color: '#9CA3AF',
                        stepSize: 20
                    },
                    grid: {
                        color: '#374151',
                        drawBorder: false
                    }
                }
            }
        }
    });

});
</script>
@endsection