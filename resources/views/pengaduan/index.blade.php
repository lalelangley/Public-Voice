@foreach ($pengaduan as $p)
    <p>{{ $p->tgl_pengaduan }} - {{ $p->isi_laporan }} ({{ $p->status }})</p>
    @if ($p->foto)
        <img src="{{ asset('storage/' . $p->foto) }}" width="100">
    @endif
@endforeach
<a href="/pengaduan/create">Buat Pengaduan Baru</a>
