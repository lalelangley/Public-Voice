@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Tambah Petugas</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="nama" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" required class="w-full border p-2 rounded">
            </div>            
            <div>
                <label class="block font-medium">Username</label>
                <input type="text" name="username" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Password</label>
                <input type="password" name="password" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Telepon</label>
                <input type="text" name="telp" required class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Divisi</label>
                <input type="text" name="divisi" required class="w-full border p-2 rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</div>
@endsection
