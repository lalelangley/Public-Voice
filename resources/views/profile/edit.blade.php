@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">✏️ Edit Profil</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-5">
        @csrf
        <div class="mb-4">
            <label class="block font-medium">Foto Profil</label>
            <input type="file" name="foto" id="foto" class="w-full border p-2 rounded" onchange="previewImage(event)">
            <img id="preview" class="mt-3 w-24 h-24 rounded-full object-cover border" 
                src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/default.png') }}" 
                alt="Preview">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Nama</label>
            <input type="text" name="nama" value="{{ old('nama', Auth::user()->nama) }}" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Username</label>
            <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Telepon</label>
            <input type="text" name="telp" value="{{ old('telp', Auth::user()->telp) }}" class="w-full border p-2 rounded">
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

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('preview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
