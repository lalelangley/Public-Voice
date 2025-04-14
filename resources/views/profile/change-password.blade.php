@extends('layouts.app')

@section('title', 'Ubah Kata Sandi')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">🔑 Ubah Kata Sandi</h1>

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('profile.change-password') }}" method="POST">
        @csrf

        @php
            $isDefaultPassword = Hash::check('0000000000000', Auth::guard('masyarakat')->user()->password);
        @endphp

        <div class="mb-4">
            <label for="current_password" class="block font-medium">Kata Sandi Saat Ini</label>
            
            @if($isDefaultPassword)
                <input type="text" value="Tidak Perlu diisi" readonly disabled class="w-full border p-2 rounded bg-gray-100 text-gray-600">
                <input type="hidden" name="current_password" value="0000000000000">
            @else
                <input type="password" id="current_password" name="current_password" required class="w-full border p-2 rounded">
            @endif
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium">Kata Sandi Baru</label>
            <input type="password" id="password" name="password" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block font-medium">Konfirmasi Kata Sandi Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full border p-2 rounded">
        </div>

        <div class="flex space-x-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                💾 Simpan
            </button>
            <a href="{{ route('profile.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                🔙 Batal
            </a>
        </div>
    </form>
</div>
@endsection
