<p>{{ $pengaduan->tgl_pengaduan }} - {{ $pengaduan->isi_laporan }}</p>
@if ($pengaduan->foto)
    <img src="{{ asset('storage/' . $pengaduan->foto) }}" width="100">
@endif

@if ($pengaduan->status == '0')
    <form action="/tanggapan/{{ $pengaduan->id_pengaduan }}/verify" method="POST">
        @csrf
        <button type="submit">Verifikasi</button>
    </form>
@elseif ($pengaduan->status == 'proses')
    <form action="/tanggapan/{{ $pengaduan->id_pengaduan }}" method="POST">
        @csrf
        <textarea name="tanggapan" placeholder="Masukkan tanggapan"></textarea>
        <button type="submit">Kirim Tanggapan</button>
    </form>
@endif
