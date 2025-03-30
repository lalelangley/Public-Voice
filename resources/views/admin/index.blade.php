@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Daftar Petugas</h2>
    <a href="{{ route('admin.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Admin</a>

    <div class="bg-white p-6 rounded-lg shadow-md mt-4">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Username</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td class="p-2 border">{{ $admin->nama }}</td>
                    <td class="p-2 border">{{ $admin->username }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.edit', $admin->id) }}" class="text-blue-500">Edit</a> |
                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
