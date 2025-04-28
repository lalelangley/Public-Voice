@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" x-data="{
        search: '{{ request('search') }}',
        kategori: '{{ request('kategori') }}',
        tahun: '{{ request('tahun') }}',
        bulan: '{{ request('bulan') }}',
        sort: '{{ request('sort') }}',
        updateFilters() {
            let queryString = '?';
            if (this.search) queryString += 'search=' + this.search + '&';
            if (this.kategori) queryString += 'kategori=' + this.kategori + '&';
            if (this.tahun) queryString += 'tahun=' + this.tahun + '&';
            if (this.bulan) queryString += 'bulan=' + this.bulan + '&';
            if (this.sort) queryString += 'sort=' + this.sort + '&';
            window.location.href = '/pengaduan' + queryString;
        }
    }">
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

    {{-- Filter --}}
    <form @input="updateFilters" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <input type="text" x-model="search" placeholder="Cari judul/isi..." class="border p-2 rounded text-sm">
        <select x-model="kategori" @change="updateFilters" class="border p-2 rounded text-sm">
            <option value="">Semua Kategori</option>
            @foreach($kategoriList as $kategori)
                <option value="{{ $kategori }}" :selected="kategori == '{{ $kategori }}'">
                    {{ ucfirst($kategori) }}
                </option>
            @endforeach
        </select>
        <input type="number" x-model="tahun" @change="updateFilters" placeholder="Tahun" class="border p-2 rounded text-sm">
        <select x-model="bulan" @change="updateFilters" class="border p-2 rounded text-sm">
            <option value="">Semua Bulan</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" :selected="bulan == {{ $i }}">
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select>
        <select x-model="sort" @change="updateFilters" class="border p-2 rounded text-sm">
            <option value="">Urutkan</option>
            <option value="like" :selected="sort == 'like'">Paling Banyak Like</option>
            <option value="komentar" :selected="sort == 'komentar'">Paling Banyak Komentar</option>
            <option value="baru" :selected="sort == 'baru'">Terbaru</option>
            <option value="lama" :selected="sort == 'lama'">Terlama</option>
        </select>
    </form>

    <div class="flex space-x-4 border-b border-gray-200 mb-6">
        @php
            $tabs = [
                'semua' => 'Semua',
                'pending' => 'Belum',
                'proses' => 'Proses',
                'selesai' => 'Selesai',
            ];
        @endphp

        @foreach ($tabs as $key => $label)
            @php
                $isActive = ($status == $key || ($key == 'semua' && !$status));
            @endphp
            <a href="{{ $key == 'semua' ? url('/pengaduan') : url('/pengaduan?status=' . $key) }}"
                class="pb-2 {{ $isActive ? 'border-b-4 border-gray-500 font-semibold text-gray-900' : 'text-gray-500 hover:text-blue-600' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar Pengaduan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($pengaduan as $p)
            {{-- Card pengaduan --}}
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
                        {{ strtoupper($kategoriMap[$p->kategori_ml] ?? $p->kategori ?? 'Umum') }}
                    </span>
                </div>

                {{-- Judul dan Isi --}}
                <h2 class="text-md font-bold text-gray-900">{{ $p->judul }}</h2>
                <p class="text-gray-700 my-1 text-xs">{{ Str::limit($p->isi_laporan, 50) }}</p>

                {{-- Foto --}}
                @if ($p->foto)
                <div x-data="{ open: false }">
                    <button @click="open = true" class="inline-block mt-2 px-2 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition text-xs">
                        Lihat Foto
                    </button>

                    <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg p-4 relative max-w-md w-full">
                            <button @click="open = false" class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-xl font-bold">&times;</button>
                            <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Laporan" class="rounded w-full object-contain max-h-[400px]">
                        </div>
                    </div>
                </div>
                @endif

                {{-- Footer --}}
                <div class="flex items-center justify-between mt-2 text-xs text-gray-600">
                    <div class="flex items-center space-x-2">
                        {{-- Komentar --}}
                        <div x-data="{ openKomentar: false }" class="mt-2">
                            <button @click="openKomentar = true" class="text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 text-gray-800 transition">
                                💬 Komentar ({{ $p->komentar->count() }})
                            </button>
                            {{-- Modal Komentar --}}
                            <div x-show="openKomentar" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-4 relative">
                                    <button @click="openKomentar = false" class="absolute top-2 right-3 text-gray-600 hover:text-red-500 text-xl font-bold">&times;</button>
                                    <h2 class="text-sm font-bold text-blue-700 mb-2">💬 Komentar</h2>
                                    <div class="max-h-60 overflow-y-auto mb-2 space-y-2">
                                        @forelse ($p->komentar as $komentar)
                                            <div class="text-xs border-b pb-1">
                                                <span class="font-semibold text-gray-800">{{ $komentar->masyarakat->nama ?? 'Anonim' }}</span>:
                                                <span class="text-gray-700">{{ $komentar->isi }}</span><br>
                                                <span class="text-[10px] text-gray-400">{{ $komentar->created_at->diffForHumans() }}</span>
                                            </div>
                                        @empty
                                            <p class="text-xs text-gray-500">Belum ada komentar.</p>
                                        @endforelse
                                    </div>
                                    @if(auth('masyarakat')->check())
                                        <form action="{{ route('pengaduan.komentar', $p->id) }}" method="POST" class="space-y-2">
                                            @csrf
                                            <input type="text" name="isi" placeholder="Tulis komentar..." class="w-full text-xs border p-2 rounded" required>
                                            <button type="submit" class="w-full bg-blue-600 text-white py-1 text-xs rounded hover:bg-blue-700">Kirim</button>
                                        </form>
                                    @else
                                        <p class="text-xs text-red-500 mt-2">Login sebagai masyarakat untuk komentar.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Dukung --}}
                        <form action="{{ route('pengaduan.like', $p->id) }}" method="POST">
                            @csrf
                            @php
                                $sudahLike = $p->likes->where('masyarakat_id', auth('masyarakat')->id())->count() > 0;
                            @endphp
                            <button type="submit" class="text-xs px-2 py-1 rounded {{ $sudahLike ? 'bg-red-200 text-red-800 hover:bg-red-300' : 'bg-blue-200 text-blue-800 hover:bg-blue-300' }}">
                                {{ $sudahLike ? '💔 Batal Dukung' : '👍 Dukung' }} ({{ $p->likes->count() }})
                            </button>
                        </form>
                    </div>
                    <a href="{{ route('pengaduan.download', $p->id) }}" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 text-xs">
                        ⬇ Download
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center col-span-3 text-gray-500">Tidak ada laporan ditemukan.</div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="w-full mt-8 flex justify-center">
        {{ $pengaduan->links() }}
    </div>

</div>
@endsection