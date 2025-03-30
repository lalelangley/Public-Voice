@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-center text-3xl font-bold text-blue-700 mb-6">Beri Tanggapan</h1>

    <div class="max-w-4xl mx-auto">
        <!-- Card Detail Laporan -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <div class="bg-blue-600 text-white text-lg font-semibold p-4 rounded-t-lg flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Detail Laporan
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <!-- Foto Pelapor -->
                    <div>
                        @if($pengaduan->masyarakat?->foto)
                            <img src="{{ asset('storage/' . $pengaduan->masyarakat->foto) }}" 
                                alt="Foto Pelapor" class="w-12 h-12 rounded-full border-2 border-blue-600 object-cover">
                        @else
                            <img src="https://via.placeholder.com/48" 
                                alt="Foto Tidak Tersedia" class="w-12 h-12 rounded-full border border-gray-300">
                        @endif
                    </div>
                    
                    <!-- Info Pelapor -->
                    <div>
                        <p class="text-md font-bold text-blue-600">{{ $pengaduan->masyarakat->nama ?? 'Tidak diketahui' }}</p>
                        <p class="text-xs text-gray-500">{{ $pengaduan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <!-- Isi Laporan -->
                <p class="mb-2 text-sm font-semibold">Isi Laporan:</p>
                <div class="bg-gray-100 p-4 rounded-lg text-gray-700 text-sm">
                    {{ $pengaduan->isi_laporan }}
                </div>

                @if($pengaduan->foto)
                    <p class="mt-4 text-sm font-semibold">Foto Laporan:</p>
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" 
                        alt="Foto Laporan" class="w-full rounded-lg border border-gray-300 max-h-64 object-contain">
                @endif
            </div>
        </div>

        <!-- Card Form Tanggapan -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="bg-green-600 text-white text-lg font-semibold p-4 rounded-t-lg flex items-center">
                <i class="fas fa-comment-dots mr-2"></i> Isi Tanggapan
            </div>
            <div class="p-6">
                <form action="{{ route('tanggapan.store', $pengaduan->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="tanggapan" class="block text-gray-700 font-semibold mb-2 text-sm">Tanggapan</label>
                        <textarea name="tanggapan" id="tanggapan" class="w-full p-3 border border-blue-400 rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none text-sm" rows="4" required></textarea>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="window.history.back()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-paper-plane"></i> Kirim Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
