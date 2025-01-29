@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    
<div class="container mx-auto max-w-lg p-8 bg-white shadow-md rounded-lg">

    <h1 class="text-2xl font-bold mb-4 text-center">Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" id="userForm" method="POST">
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
                <option value="UP" {{ $user->role == 'UP' ? 'selected' : '' }}>UP</option>
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

        <div class="flex justify-end items-center">
            <button type="button" id="openModalButton" class="bg-btn hover:bg-btnh text-txtd px-4 py-2 rounded">Update</button>
        </div>
    </form>
    
    <!-- Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
            <p>Apakah Anda yakin ingin menyimpan data user?</p>
            <div class="flex justify-end mt-4">
                <button id="cancelButton" class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 rounded-md">Batal</button>
                <button id="confirmButton" class="px-4 py-2 bg-btn hover:bg-btnh text-white rounded-md">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
	document.getElementById('openModalButton').addEventListener('click', function() {
		document.getElementById('confirmationModal').classList.remove('hidden');
	});

	document.getElementById('cancelButton').addEventListener('click', function() {
		document.getElementById('confirmationModal').classList.add('hidden');
	});

	document.getElementById('confirmButton').addEventListener('click', function() {
		document.getElementById('userForm').submit();
	});
</script>
@endpush



@endsection
