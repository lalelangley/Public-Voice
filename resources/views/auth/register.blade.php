<form action="/register" method="POST">
    @csrf
    <input type="text" name="nik" placeholder="NIK">
    <input type="text" name="nama" placeholder="Nama">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="text" name="telp" placeholder="No Telp">
    <button type="submit">Register</button>
</form>
