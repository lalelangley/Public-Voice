<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <h2>Laporan Pengaduan {{ $divisi ? "Divisi $divisi" : "Semua Divisi" }}</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Isi Laporan</th>
                <th>Divisi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduan as $p)
                <tr>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                    <td>{{ $p->judul }}</td>
                    <td>{{ $p->isi_laporan }}</td>
                    <td>{{ $p->divisi }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
