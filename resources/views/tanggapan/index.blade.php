@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-blue-700">Daftar Laporan</h1>
        <a href="{{ route('petugas.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            ⬅ Kembali ke Dashboard
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-blue-600 text-white text-left">
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Pelapor</th>
                    <th class="px-4 py-3">Isi Laporan</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-blue-50">
                @foreach ($pengaduan as $p)
                    <tr class="border-b hover:bg-blue-100 transition">
                        <td class="px-4 py-3 text-blue-700">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-4 py-3 font-bold text-blue-800">
                            {{ $p->masyarakat?->nama ?? 'Tidak diketahui' }}
                        </td>
                        <td class="px-4 py-3 text-blue-600">{{ Str::limit($p->isi_laporan, 50) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-white text-sm font-semibold
                                {{ $p->status == 'pending' ? 'bg-yellow-500' : ($p->status == 'proses' ? 'bg-blue-500' : 'bg-green-500') }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ url('/tanggapan/' . $p->id_pengaduan) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                                Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
