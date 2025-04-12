<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-6 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>
        @if (session('status'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('status') }}
    </div>
    @endif

        @if(session('error'))
            <div class="bg-red-200 p-3 rounded text-red-800 mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf  

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan Username" required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan Password" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                Login
            </button>
        </form>

        <a href="{{ route('google.login') }}" class="block w-full text-center bg-red-500 text-white py-2 rounded-lg mt-3 hover:bg-red-600 transition duration-200">
            Login dengan Google
        </a>    

        <p class="text-center text-sm text-gray-600 mt-4">
            <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">Lupa Password?</a>
        </p>

        <p class="text-center text-sm text-gray-600 mt-2">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar di sini</a>
        </p>
    </div>

</body>
</html>
