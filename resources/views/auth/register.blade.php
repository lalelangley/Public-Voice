<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center mb-4">Register</h2>

        <!-- Notifikasi Berhasil -->
        @if(session('success'))
            <div class="bg-green-200 p-3 rounded text-green-800 mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="/register" method="POST" class="space-y-4">
            @csrf  

            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan NIK" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan Nama" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan Username" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan Password" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">No Telp</label>
                <input type="text" name="telp" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan No Telp" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                Register
            </button>
        </form>

        <p class="text-center text-sm mt-4">
            Sudah punya akun? <a href="/login" class="text-blue-500 hover:underline">Login di sini</a>
        </p>
    </div>

</body>
</html>
