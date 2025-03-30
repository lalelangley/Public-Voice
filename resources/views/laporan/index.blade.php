<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Laporan Pengaduan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Laporan Pengaduan</h1>

        <a href="{{ route('laporan.pdf') }}" class="btn btn-danger mb-3">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
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
                        <td>
                            @if($item->status == 'proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @elseif($item->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
