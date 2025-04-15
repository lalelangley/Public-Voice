@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Dashboard Admin</h2>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Logout
            </button>
        </form>
    </div>

    {{-- Daftar Petugas --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Daftar Petugas</h3>
            <a href="{{ route('admin.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Tambah Petugas
            </a>            
        </div>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Username</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugas as $p)
                <tr>
                    <td class="p-2 border">{{ $p->nama }}</td>
                    <td class="p-2 border">{{ $p->username }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.edit', $p->id) }}" class="text-blue-500 hover:underline">Edit</a> |
                        <form action="{{ route('admin.destroy', $p->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center p-2">Belum ada petugas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
