@foreach ($pengaduan as $p)
    <p>{{ $p->tgl_pengaduan }} - {{ $p->isi_laporan }} ({{ $p->status }})</p>
    <a href="/tanggapan/{{ $p->id_pengaduan }}">Lihat Detail</a>
@endforeach
