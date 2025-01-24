@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    
<div class="p-4 sm:ml-64">
	<h1 class="text-2xl font-bold mb-4">Tambah User</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block">Nama</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">NPP</label>
            <input type="text" name="npp" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Password</label>
            <input type="password" name="password" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Role</label>
            <select name="role" class="w-full p-2 border rounded">
                <option value="UK">UK</option>
                <option value="Pegawai">Pegawai</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block">Department</label>
            <select name="department" class="w-full p-2 border rounded">
                <option value="PMU">PMU</option>
                <option value="YANFASKES">YANFASKES</option>
                <option value="YANSER">YANSER</option>
                <option value="KEPSER">KEPSER</option>
                <option value="PKP">PKP</option>
                <option value="SDMUK">SDMUK</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>


@push('scripts')
@endpush



@endsection
