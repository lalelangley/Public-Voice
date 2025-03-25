<form action="/pengaduan" method="POST">
    @csrf
    <label for="isi_laporan">Isi Laporan:</label>
    <textarea name="isi_laporan" required></textarea>

    <label for="kategori">Kategori:</label>
    <select name="kategori" required>
        <option value="lingkungan">Lingkungan</option>
        <option value="polisi">Polisi</option>
        <option value="kesehatan">Kesehatan</option>
    </select>

    <button type="submit">Kirim Pengaduan</button>
</form>
