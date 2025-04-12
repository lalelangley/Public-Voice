@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">👤 Profil Saya</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center space-x-4">
        <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/user.jpeg') }}" 
            class="w-24 h-24 rounded-full object-cover border" alt="Foto Profil">
        <div>
            <p class="text-lg"><strong>Nama:</strong> {{ Auth::user()->nama }}</p>
            <p class="text-lg"><strong>Username:</strong> {{ Auth::user()->username }}</p>
            <p class="text-lg"><strong>Telepon:</strong> {{ Auth::user()->telp ?? '-' }}</p>
        </div>
    </div>

    <div class="mt-5 flex space-x-3">
        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
            ✏️ Edit Profil
        </a>
        <a href="{{ route('masyarakat.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
            ⬅️ Kembali ke Dashboard
        </a>
        <a href="{{ route('profile.change-password-form') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
            🔑 Ganti Kata Sandi
        </a>
    </div>    
</div>
@endsection
