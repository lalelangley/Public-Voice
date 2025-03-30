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
@endsection
