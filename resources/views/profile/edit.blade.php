@extends('layouts.app')

@section('title', 'Ubah Profil')

@section('content')
<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Ubah Profil</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Informasi Publik -->
            <div>
                <h2 class="font-semibold text-lg mb-2 border-b pb-1">Informasi Publik</h2>

                <label class="block mt-3">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', Auth::guard('masyarakat')->user()->nama) }}" class="w-full border p-2 rounded" required>

                <label class="block mt-3">Username</label>
                <input type="text" name="username" value="{{ old('username', Auth::guard('masyarakat')->user()->username) }}" class="w-full border p-2 rounded" required>

                <label class="block mt-3">Bio</label>
                <textarea name="bio" rows="3" class="w-full border p-2 rounded">{{ old('bio', Auth::guard('masyarakat')->user()->bio) }}</textarea>

                <label class="block mt-3">Foto Profil</label>
                <input type="file" name="foto" class="border p-2 rounded w-full" onchange="previewImage(event)">
                <img id="preview" src="{{ Auth::guard('masyarakat')->user()->foto ? asset('storage/' . Auth::guard('masyarakat')->user()->foto) : asset('images/default.png') }}" class="mt-3 w-24 h-24 object-cover rounded-full border" />
            </div>

            <!-- Data Pribadi -->
            <div>
                <h2 class="font-semibold text-lg mb-2 border-b pb-1">Data Pribadi</h2>

                <label class="block mt-3">Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::guard('masyarakat')->user()->email) }}" class="w-full border p-2 rounded" required>

                <label class="block mt-3">No HandPhone</label>
                <input type="text" name="telp" value="{{ old('telp', Auth::guard('masyarakat')->user()->telp) }}" class="w-full border p-2 rounded" required>

                <label class="block mt-3">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', Auth::guard('masyarakat')->user()->tanggal_lahir) }}" class="w-full border p-2 rounded">

                <label class="block mt-3">Jenis Kelamin</label>
                <div class="flex items-center space-x-4">
                    <label><input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', Auth::user()->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', Auth::user()->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
                </div>

                <label class="block mt-3">Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ old('pekerjaan', Auth::guard('masyarakat')->user()->pekerjaan) }}" class="w-full border p-2 rounded">

                <label class="block mt-3">Alamat Saat Ini</label>
                <textarea name="alamat" rows="2" class="w-full border p-2 rounded">{{ old('alamat', Auth::guard('masyarakat')->user()->tempat_tinggal) }}</textarea>
            </div>
        </div>

        <div class="mt-6 text-center">
            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">Kirim</button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
