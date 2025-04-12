@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 border-b-4 border-blue-300 pb-2">Daftar Laporan</h1>

    {{-- Navigasi --}}
    <div class="flex justify-between mb-6">
        <a href="{{ url('/masyarakat/dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition">
            ⬅ Kembali ke Dashboard
        </a>
        <a href="{{ url('/pengaduan/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
            ➕ Buat Laporan Baru
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Pengaduan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($pengaduan as $p)
            <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">
                            <span>{{ $p->anonim ? '?' : strtoupper(substr($p->masyarakat->nama ?? 'A', 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">
                                {{ $p->anonim ? 'Dirahasiakan' : $p->masyarakat->nama }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $p->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                    <span class="bg-blue-800 text-white text-xs px-2 py-1 rounded-full uppercase">
                        {{ strtoupper($p->kategori ?? 'Umum') }}
                    </span>
                </div>

                {{-- Judul dan Isi --}}
                <h2 class="text-md font-bold text-gray-900">{{ $p->judul }}</h2>
                <p class="text-gray-700 my-1 text-xs">{{ Str::limit($p->isi_laporan, 50) }}</p>

                {{-- Tombol Lihat Foto --}}
                @if ($p->foto)
                <div x-data="{ open: false }">
                    <button @click="open = true"
                        class="inline-block mt-2 px-2 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition text-xs">
                        Lihat Foto
                    </button>

                    {{-- Modal --}}
                    <div x-show="open" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg p-4 relative max-w-md w-full">
                            <button @click="open = false"
                                    class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-xl font-bold">&times;</button>
                            <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Laporan"
                                class="rounded w-full object-contain max-h-[400px]">
                        </div>
                    </div>
                </div>
            @endif


                {{-- Footer --}}
                <div class="flex items-center justify-between mt-2 text-xs text-gray-600">
                    <div class="flex items-center space-x-2">
                        <span>💬 0 Komentar</span>
                        <span>👍 0 Dukungan</span>
                    </div>
                    <a href="#" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600">
                        ⬇ Download Laporan
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection