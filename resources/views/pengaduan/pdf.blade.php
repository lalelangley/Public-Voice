<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: sans-serif; }
        h1 { color: #05284E; }
        .label { font-weight: bold; }
        .box { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Laporan Pengaduan</h1>
    <div class="box">
        <p><span class="label">Judul:</span> {{ $pengaduan->judul }}</p>
        <p><span class="label">Pelapor:</span> {{ $pengaduan->anonim ? 'Dirahasiakan' : $pengaduan->masyarakat->nama }}</p>
        <p><span class="label">Tanggal Kejadian:</span> {{ \Carbon\Carbon::parse($pengaduan->tanggal_kejadian)->format('d F Y') }}</p>
        <p><span class="label">Lokasi Kejadian:</span> {{ $pengaduan->lokasi_kejadian }}</p>
        <p><span class="label">Isi Laporan:</span></p>
        <p>{{ $pengaduan->isi_laporan }}</p>
    </div>

    @if ($pengaduan->foto)
        <p><span class="label">Foto:</span></p>
        <img src="{{ public_path('storage/' . $pengaduan->foto) }}" style="width:100%; max-height:300px;">
    @endif
</body>
</html>
