@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Edit Petugas</h2>

    <form action="{{ route('admin.update', $petugas->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-4">
            <label class="block font-semibold">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', $petugas->nama) }}" class="border rounded px-4 py-2 w-full">
        </div>

        {{-- Username --}}
        <div class="mb-4">
            <label class="block font-semibold">Username</label>
            <input type="text" name="username" value="{{ old('username', $petugas->username) }}" class="border rounded px-4 py-2 w-full">
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $petugas->email) }}" class="border rounded px-4 py-2 w-full">
        </div>

        {{-- Telepon --}}
        <div class="mb-4">
            <label class="block font-semibold">Telepon</label>
            <input type="text" name="telp" value="{{ old('telp', $petugas->telp ?? '') }}" class="border rounded px-4 py-2 w-full">
        </div>

        {{-- Divisi --}}
        <div class="mb-4">
            <label class="block font-semibold">Divisi</label>
            <input type="text" name="divisi" value="{{ old('divisi', $petugas->divisi ?? '') }}" class="border rounded px-4 py-2 w-full">
        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Update
            </button>
            <a href="{{ route('admin.dashboard') }}" class="text-red-500 hover:underline ml-2">
                ❌ Cancel
            </a>
        </div>
    </form>
</div>
@endsection
