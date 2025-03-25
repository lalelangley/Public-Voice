<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Pengaduan</h2>
    <table>
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
