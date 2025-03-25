<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Laporan Pengaduan</title>
</head>
<body>
    <h1>Laporan Pengaduan</h1>
    <a href="{{ route('laporan.pdf') }}">Download PDF</a>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelapor</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Tanggal Pengaduan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduan as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->masyarakat->nama }}</td>
                <td>{{ $item->isi_laporan }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
