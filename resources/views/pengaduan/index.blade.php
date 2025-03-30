@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Daftar Pengaduan</h1>

    {{-- Tombol navigasi --}}
    <div class="flex justify-between mb-6">
        <a href="{{ url('/masyarakat/dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
            ⬅ Kembali ke Dashboard
        </a>
        <a href="{{ url('/pengaduan/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            ➕ Buat Laporan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-blue-600 text-white text-left">
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Isi Laporan</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="bg-blue-50">
                @foreach ($pengaduan as $p)
                    <tr class="border-b hover:bg-blue-100 transition">
                        <td class="px-4 py-3 text-blue-700">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 font-bold text-blue-800">{{ $p->judul }}</td>
                        <td class="px-4 py-3 text-blue-600">{{ Str::limit($p->isi_laporan, 50) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-white text-sm font-semibold
                                {{ $p->status == 'pending' ? 'bg-yellow-500' : ($p->status == 'proses' ? 'bg-blue-500' : 'bg-green-500') }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
