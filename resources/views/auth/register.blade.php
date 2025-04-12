<form action="{{ route('register') }}" method="POST" class="space-y-4">
    @csrf  

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded-lg text-center">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded-lg">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- NIK -->
    <div>
        <label class="block text-sm font-medium text-gray-700">NIK</label>
        <input type="text" name="nik" value="{{ old('nik') }}" class="w-full p-2 border rounded-lg" placeholder="Masukkan NIK" required>
        @error('nik') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Nama -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full p-2 border rounded-lg" placeholder="Masukkan Nama" required>
        @error('nama') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Username -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" name="username" value="{{ old('username') }}" class="w-full p-2 border rounded-lg" placeholder="Masukkan Username" required>
        @error('username') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Password -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" class="w-full p-2 border rounded-lg" placeholder="Masukkan Password" required>
        @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full p-2 border rounded-lg" placeholder="Ulangi Password" required>
    </div>

    <!-- No Telp -->
    <div>
        <label class="block text-sm font-medium text-gray-700">No Telp</label>
        <input type="text" name="telp" value="{{ old('telp') }}" class="w-full p-2 border rounded-lg" placeholder="Masukkan No Telp" required>
        @error('telp') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Email -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Email (opsional)</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full p-2 border rounded-lg" placeholder="Masukkan Email">
        @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Tempat Tinggal -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Tempat Tinggal</label>
        <input type="text" name="tempat_tinggal" value="{{ old('tempat_tinggal') }}" class="w-full p-2 border rounded-lg" placeholder="Masukkan Alamat">
        @error('tempat_tinggal') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Tanggal Lahir -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full p-2 border rounded-lg">
        @error('tanggal_lahir') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Jenis Kelamin -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="w-full p-2 border rounded-lg">
            <option value="">-- Pilih --</option>
            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Pekerjaan -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full p-2 border rounded-lg" placeholder="Masukkan Pekerjaan">
        @error('pekerjaan') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Disabilitas -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Disabilitas</label>
        <select name="disabilitas" class="w-full p-2 border rounded-lg">
            <option value="">-- Pilih --</option>
            <option value="1" {{ old('disabilitas') == '1' ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ old('disabilitas') == '0' ? 'selected' : '' }}>Tidak</option>
        </select>
        @error('disabilitas') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Submit -->
    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-200">
        Register
    </button>
</form>
