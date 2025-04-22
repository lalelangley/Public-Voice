@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-center text-3xl font-bold text-blue-700 mb-6">Beri Tanggapan</h1>

    <div class="max-w-4xl mx-auto">
        @isset($pengaduan)
        <!-- Card Detail Laporan -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <div class="bg-blue-600 text-white text-lg font-semibold p-4 rounded-t-lg flex items-center">
                <i class="fas fa-file-alt mr-2"></i> Detail Laporan
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <!-- Foto Pelapor -->
                    <div>
                        @if(optional($pengaduan->masyarakat)->foto)
                            <img src="{{ asset('storage/' . $pengaduan->masyarakat->foto) }}" 
                                alt="Foto Pelapor" class="w-12 h-12 rounded-full border-2 border-blue-600 object-cover">
                        @else
                            <img src="https://via.placeholder.com/48" 
                                alt="Foto Tidak Tersedia" class="w-12 h-12 rounded-full border border-gray-300">
                        @endif
                    </div>
                    
                    <!-- Info Pelapor -->
                    <div>
                        <p class="text-md font-bold text-blue-600">{{ optional($pengaduan->masyarakat)->nama ?? 'Tidak diketahui' }}</p>
                        <p class="text-xs text-gray-500">{{ optional($pengaduan->created_at)->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <!-- Isi Laporan -->
                <p class="mb-2 text-sm font-semibold">Isi Laporan:</p>
                <div class="bg-gray-100 p-4 rounded-lg text-gray-700 text-sm">
                    {{ $pengaduan->isi_laporan ?? 'Tidak ada laporan' }}
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
                <form action="{{ route('tanggapan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->id }}">

                    <div class="mb-4">
                        <label for="tanggapan" class="block text-sm font-medium text-gray-700">Tanggapan</label>
                        <textarea name="tanggapan" id="tanggapan" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="4" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Pengaduan</label>
                        <select name="status" id="status" class="form-control mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="pending">Pending</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Kirim Tanggapan
                    </button>
                </form>
            </div>
        </div>
        @else
            <div class="text-center text-red-600 text-lg font-semibold">
                Data pengaduan tidak ditemukan.
            </div>
        @endisset
    </div>
</div>
@endsection
