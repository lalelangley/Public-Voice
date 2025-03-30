@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Petugas</h1>
    <p>Selamat datang di panel petugas.</p>

    <div class="d-flex gap-3 mt-4">
        <a href="{{ route('laporan.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-eye"></i> Lihat Laporan
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-lg">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>
@endsection
