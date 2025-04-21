@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 border-b-4 border-blue-300 pb-2">Buat Laporan Baru</h1>

    {{-- Navigasi --}}
    <div class="mb-6">
        <a href="{{ url('/masyarakat/dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition">
            ⬅ Kembali ke Dashboard
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Pengaduan</label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" required>
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="isi_laporan" class="form-label">Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control @error('isi_laporan') is-invalid @enderror" required></textarea>
            @error('isi_laporan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
            <input type="date" name="tanggal_kejadian" class="form-control @error('tanggal_kejadian') is-invalid @enderror" required>
            @error('tanggal_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
            <input type="text" name="lokasi_kejadian" class="form-control @error('lokasi_kejadian') is-invalid @enderror" required>
            @error('lokasi_kejadian')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kerahasiaan</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="anonim" id="anonim" value="1">
                <label class="form-check-label" for="anonim">Anonim</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
    </form>
</div>
@endsection
