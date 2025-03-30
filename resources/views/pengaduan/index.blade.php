@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6 border-b-4 border-blue-300 pb-2">Daftar Pengaduan</h1>

    {{-- Tombol navigasi --}}
    <div class="flex justify-between mb-6">
        <a href="{{ url('/masyarakat/dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition">
            ⬅ Kembali ke Dashboard
        </a>
        <a href="{{ url('/pengaduan/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition">
            ➕ Buat Laporan Baru
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Pengaduan --}}
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-blue-600 text-white text-left">
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Judul</th>
                    <th class="px-6 py-3">Isi Laporan</th>
                    <th class="px-6 py-3">Foto</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tanggapan Petugas</th>
                </tr>
            </thead>
            <tbody class="bg-blue-50">
                @foreach ($pengaduan as $p)
                    <tr class="border-b hover:bg-blue-100 transition">
                        <td class="px-6 py-4 text-blue-700 whitespace-nowrap">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-bold text-blue-800">{{ $p->judul }}</td>
                        <td class="px-6 py-4 text-blue-600">{{ Str::limit($p->isi_laporan, 50) }}</td>
                        <td class="px-6 py-4">
                            @if ($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Laporan"
                                    class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow">
                            @else
                                <span class="text-gray-500">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-4 py-2 rounded-full text-white text-sm font-semibold shadow-md
                                {{ $p->status == 'pending' ? 'bg-yellow-500' : ($p->status == 'proses' ? 'bg-blue-500' : 'bg-green-500') }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($p->tanggapan)
                                <div class="bg-white p-3 rounded-lg shadow-md border border-gray-300">
                                    <p class="text-gray-700 font-semibold">{{ $p->tanggapan->tanggapan }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Diberikan oleh: <span class="font-semibold">{{ $p->tanggapan->petugas->nama ?? 'Petugas Tidak Diketahui' }}</span></p>
                                    <p class="text-xs text-gray-400">{{ $p->tanggapan->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            @else
                                <span class="text-gray-500">Belum ada tanggapan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
