@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    
<div class="p-4 sm:ml-64">
	<h1 class="text-2xl font-bold mb-4">Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">NPP</label>
            <input type="text" name="npp" value="{{ old('npp', $user->npp) }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Password (Kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block">Role</label>
            <select name="role" class="w-full p-2 border rounded">
                <option value="UK" {{ $user->role == 'UK' ? 'selected' : '' }}>UK</option>
                <option value="Pegawai" {{ $user->role == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block">Department</label>
            <select name="department" class="w-full p-2 border rounded">
                <option value="PMU" {{ $user->department == 'PMU' ? 'selected' : '' }}>PMU</option>
                <option value="YANFASKES" {{ $user->department == 'YANFASKES' ? 'selected' : '' }}>YANFASKES</option>
                <option value="YANSER" {{ $user->department == 'YANSER' ? 'selected' : '' }}>YANSER</option>
                <option value="KEPSER" {{ $user->department == 'KEPSER' ? 'selected' : '' }}>KEPSER</option>
                <option value="PKP" {{ $user->department == 'PKP' ? 'selected' : '' }}>PKP</option>
                <option value="SDMUK" {{ $user->department == 'SDMUK' ? 'selected' : '' }}>SDMUK</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>


@push('scripts')
@endpush



@endsection
