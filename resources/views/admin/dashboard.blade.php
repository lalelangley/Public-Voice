@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Admin')

@section('content')
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Daftar Petugas</h2>
        <a href="{{ route('admin.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Petugas</a>
    </div>

    @if(isset($petugas) && $petugas->isEmpty())
        <p class="text-gray-600">Belum ada petugas.</p>
    @elseif(isset($petugas))
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Username</th>
                </tr>
            </thead>
            <tbody>
                @foreach($petugas as $p)
                    <tr>
                        <td class="border p-2">{{ $p->name }}</td>
                        <td class="border p-2">{{ $p->username }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
    </form>
@endsection
