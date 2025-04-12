<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-96">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Reset Password</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold">Email</label>
                <input type="email" name="email" required class="w-full p-2 border rounded mt-1" value="{{ old('email', $email) }}">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold">Password Baru</label>
                <input type="password" name="password" required class="w-full p-2 border rounded mt-1">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full p-2 border rounded mt-1">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Reset Password
            </button>
        </form>
    </div>
</body>
</html>
