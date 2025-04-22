@extends('layouts.app')

@section('title', 'Dashboard Masyarakat')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Masyarakat</h1>
        
        <!-- Tombol Profile -->
        <a href="{{ route('profile.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
            👤 Profile
        </a>
    </div>

    <p class="mt-2 text-gray-600">
        Selamat datang, <span class="font-semibold">{{ Auth::guard('masyarakat')->user()->nama ?? 'Pengguna' }}</span>!
    </p>

    <div class="mt-5 flex space-x-3">
        <a href="{{ route('pengaduan.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
            📋 Lihat Pengaduan
        </a>
        <a href="{{ route('pengaduan.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
            ✏️ Buat Pengaduan Baru
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                🔴 Logout
            </button>
        </form>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="p-4 bg-blue-100 rounded shadow">
        <h2 class="text-xl font-semibold text-blue-800">Total Pengaduan</h2>
        <p class="text-2xl font-bold text-blue-900">{{ $total }}</p>
    </div>
    <div class="p-4 bg-yellow-100 rounded shadow">
        <h2 class="text-xl font-semibold text-yellow-800">Pending</h2>
        <p class="text-2xl font-bold text-yellow-900">{{ $pending }}</p>
    </div>
    <div class="p-4 bg-orange-100 rounded shadow">
        <h2 class="text-xl font-semibold text-orange-800">Diproses</h2>
        <p class="text-2xl font-bold text-orange-900">{{ $proses }}</p>
    </div>
    <div class="p-4 bg-green-100 rounded shadow">
        <h2 class="text-xl font-semibold text-green-800">Selesai</h2>
        <p class="text-2xl font-bold text-green-900">{{ $selesai }}</p>
    </div>
</div>

<div class="mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Grafik Pengaduan</h2>
    <canvas id="pengaduanChart" height="120"></canvas>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pengaduanChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Proses', 'Selesai'],
            datasets: [{
                label: 'Jumlah Pengaduan',
                data: [{{ $pending }}, {{ $proses }}, {{ $selesai }}],
                backgroundColor: [
                    'rgba(253, 224, 71, 0.7)', // kuning
                    'rgba(251, 146, 60, 0.7)', // oranye
                    'rgba(34, 197, 94, 0.7)'   // hijau
                ],
                borderColor: [
                    'rgba(202, 138, 4, 1)',
                    'rgba(194, 65, 12, 1)',
                    'rgba(22, 163, 74, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

@endsection
