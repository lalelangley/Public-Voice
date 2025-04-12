@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Buat Pengaduan Baru</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Pengaduan</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="lingkungan">Lingkungan</option>
                <option value="polisi">Polisi</option>
                <option value="kesehatan">Kesehatan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="isi_laporan" class="form-label">Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal_kejadian" class="form-label">Tanggal Kejadian</label>
            <input type="date" name="tanggal_kejadian" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lokasi_kejadian" class="form-label">Lokasi Kejadian</label>
            <input type="text" name="lokasi_kejadian" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control">
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
