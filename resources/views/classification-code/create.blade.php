@extends('layouts.app')

@section('title', 'Tambah Kode Klasifikasi')

@section('content')
    
<div class="container mx-auto max-w-lg p-8 bg-white shadow-md rounded-lg">
	<h1 class="text-2xl font-bold mb-4 text-center text-txtl">Tambah Kode Data Klasifikasi</h1>
    <form action="{{ route('classificationCode.store') }}" id="classCodeForm" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block">Kode</label>
            <input type="text" name="code" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('code')" class="mt-1 text-red-500 text-sm" />
        </div>

        <div class="mb-4">
            <label class="block">Judul</label>
            <input type="text" name="title" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('title')" class="mt-1 text-red-500 text-sm" />
        </div>

        <div class="mb-4">
            <label class="block">JRA Aktif (Tahun)</label>
            <input type="number" name="active" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('active')" class="mt-1 text-red-500 text-sm" />
        </div>

        <div class="mb-4">
            <label class="block">Keterangan JRA Aktif</label>
            <input type="text" name="ket_active" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('ket_active')" class="mt-1 text-red-500 text-sm" />
        </div>

		<div class="mb-4">
			<label class="block">JRA Inaktif (Tahun)</label>
			<input type="number" name="inactive" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('inactive')" class="mt-1 text-red-500 text-sm" />
		</div>

        <div class="mb-4">
            <label class="block">Keterangan JRA Inaktif</label>
            <input type="text" name="ket_inactive" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('ket_inactive')" class="mt-1 text-red-500 text-sm" />
        </div>

        <div class="mb-4">
            <label class="block">Keterangan</label>
            <input type="text" name="keterangan" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('keterangan')" class="mt-1 text-red-500 text-sm" />
        </div>

        <div class="mb-4">
            <label class="block">Klasifikasi Keamanan</label>
            <input type="text" name="security" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('security')" class="mt-1 text-red-500 text-sm" />
        </div>

        <div class="mb-4">
            <label class="block">Hak Akses (Pejabat yang Bertanggung Jawab)</label>
            <input type="text" name="hak_akses" class="w-full p-2 border rounded">
            <x-input-error :messages="$errors->get('hak_akses')" class="mt-1 text-red-500 text-sm" />
        </div>

        <div class="flex justify-end items-center">
            <button type="button" id="openModalButton" class="bg-btn hover:bg-btnh text-txtd px-4 py-2 rounded">Simpan</button>
        </div>
    </form>

    <!-- Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
            <p>Apakah Anda yakin ingin menyimpan data?</p>
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
		document.getElementById('classCodeForm').submit();
	});
</script>
@endpush



@endsection
