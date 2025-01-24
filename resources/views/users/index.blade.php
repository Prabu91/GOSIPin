@extends('layouts.app')

@section('title', 'Users')

@section('content')
    
<div class="p-4 sm:ml-64">
	<h1 class="text-2xl font-bold mb-4">Daftar Users</h1>
    
    <a href="{{ route('users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah User</a>

    @if (session('success'))
        <p class="mt-4 text-green-600">{{ session('success') }}</p>
    @endif

    <div class="mt-4">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">NPP</th>
                    <th class="p-2 border">Role</th>
                    <th class="p-2 border">Department</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="p-2 border">{{ $user->name }}</td>
                        <td class="p-2 border">{{ $user->npp }}</td>
                        <td class="p-2 border">{{ $user->role }}</td>
                        <td class="p-2 border">{{ $user->department }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@push('scripts')
@endpush



@endsection
