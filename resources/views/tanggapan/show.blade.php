@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Detail Pengaduan</h1>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <p><strong>Tanggal:</strong> {{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
        <p><strong>Nama Pelapor:</strong> {{ $pengaduan->masyarakat?->nama ?? 'Tidak diketahui' }}</p>
        <p><strong>Isi Laporan:</strong> {{ $pengaduan->isi_laporan }}</p>

        @if ($pengaduan->foto)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="rounded-lg shadow-md w-64">
            </div>
        @endif

        <p><strong>Status:</strong> 
            <span class="px-3 py-1 rounded-full text-white text-sm font-semibold
                {{ $pengaduan->status == 'pending' ? 'bg-yellow-500' : ($pengaduan->status == 'proses' ? 'bg-blue-500' : 'bg-green-500') }}">
                {{ ucfirst($pengaduan->status) }}
            </span>
        </p>

        {{-- **Tampilkan Tanggapan Jika Ada** --}}
        @if ($pengaduan->tanggapan)
            <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                <h3 class="font-semibold text-blue-700">Tanggapan Petugas:</h3>
                <p>{{ $pengaduan->tanggapan->isi_tanggapan }}</p>
                <p class="text-sm text-gray-600">Diberikan oleh: {{ $pengaduan->tanggapan->petugas->nama ?? 'Petugas' }}</p>
            </div>
        @endif

        {{-- **Form untuk Memberikan Tanggapan** --}}
        @if($pengaduan->status == 'proses' && Auth::guard('petugas')->check())
            <form action="{{ route('tanggapan.store', $pengaduan->id_pengaduan) }}" method="POST" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="tanggapan" class="block font-semibold">Tanggapan:</label>
                    <textarea name="tanggapan" id="tanggapan" rows="3" class="w-full p-2 border rounded-md" required></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Kirim Tanggapan
                </button>
            </form>
        @endif
    </div>

    <a href="{{ route('laporan.index') }}" class="mt-4 inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">⬅ Kembali ke Daftar Laporan</a>
</div>
@endsection
