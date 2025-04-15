@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Edit Data Admin / Petugas</h2>

    <form action="{{ route('admin.update', $petugas->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $petugas->nama) }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', $petugas->username) }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $petugas->email) }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.index') }}" class="mr-4 px-4 py-2 bg-gray-300 rounded">Batal</a>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
