<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Pengaduan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelapor</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Isi Pengaduan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduan as $key => $pengaduan)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $pengaduan->masyarakat->nama }}</td>
                <td>{{ date('d-m-Y', strtotime($pengaduan->created_at)) }}</td>
                <td>{{ $pengaduan->kategori }}</td>
                <td>{{ $pengaduan->isi_laporan }}</td>
                <td>{{ $pengaduan->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
