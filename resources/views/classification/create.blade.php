@extends('layouts.app')

@section('title', 'Tambah Klasifikasi')

@section('content')
    
<div class="p-4 sm:ml-64">
	<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
		<h1 class="text-2xl font-bold mb-4 text-txtl text-center">Tambah Data Klasifikasi</h1>
		<div class="container mx-auto max-w-4xl p-8 bg-white shadow-md rounded-lg">
			<form id="classificationForm" action="{{ route('classification.store') }}" method="POST">
				@csrf
				<div>
					<label for="nomor_berkas" class="block text-sm font-medium text-gray-700">Nomor Berkas</label>
					<input type="number" name="nomor_berkas" id="nomor_berkas" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('nomor_berkas') }}" >
					<x-input-error :messages="$errors->get('nomor_berkas')" class="mt-2" />
				</div>

				<div>
					<label for="classification_code_id" class="block text-sm font-medium text-gray-700">Judul Berkas</label>
					<select name="classification_code_id" id="classification_code_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="">Pilih Judul Berkas</option>
						@foreach($codes as $code)
							<option value="{{ $code->id }}">{{ $code->code }} - {{ $code->title }}</option>
						@endforeach
					</select>
				</div>
				

				<div>
					<label for="nomor_item_berkas" class="block text-sm font-medium text-gray-700">Nomor Item Berkas</label>
					<input type="number" name="nomor_item_berkas" id="nomor_item_berkas" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('nomor_item_berkas') }}" >
					<x-input-error :messages="$errors->get('nomor_item_berkas')" class="mt-2" />
				</div>

				<div>
					<label for="uraian_berkas" class="block text-sm font-medium text-gray-700">Uraian Berkas</label>
					<input type="text" name="uraian_berkas" id="uraian_berkas" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('uraian_berkas') }}" >
					<x-input-error :messages="$errors->get('uraian_berkas')" class="mt-2" />
				</div>

				<div>
					<label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
					<input type="date" name="date" id="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('date') }}" >
					<x-input-error :messages="$errors->get('date')" class="mt-2" />
				</div>

				<div>
					<label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
					<input type="number" name="jumlah" id="jumlah" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('jumlah') }}" >
					<x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
				</div>

				<div>
					<label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
					<input type="text" name="satuan" id="satuan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('satuan') }}" >
					<x-input-error :messages="$errors->get('satuan')" class="mt-2" />
				</div>

				<div>
					<label for="perkembangan" class="block text-sm font-medium text-gray-700">Tingkat Perkembangan</label>
					<input type="text" name="perkembangan" id="perkembangan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('perkembangan') }}" >
					<x-input-error :messages="$errors->get('perkembangan')" class="mt-2" />
				</div>

				<div>
					<label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
					<select name="lokasi" id="lokasi" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
						<option value="rak">Rak</option>
						<option value="shelf">Shelf</option>
						<option value="box">Box</option>
					</select>
				</div>
				<div>
					<label for="ket_lokasi" class="block text-sm font-medium text-gray-700">Keterangan Lokasi</label>
					<input type="text" name="ket_lokasi" id="ket_lokasi" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('ket_lokasi') }}" >
					<x-input-error :messages="$errors->get('ket_lokasi')" class="mt-2" />
				</div>

				<button type="button" id="openModalButton" 
				class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
					Simpan Data
				</button>
			</form>

			<!-- Modal -->
			<div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
				<div class="bg-white rounded-lg shadow-lg p-6">
					<h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
					<p>Apakah Anda yakin ingin menyimpan data pasien?</p>
					<div class="flex justify-end mt-4">
						<button id="cancelButton" class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md">Batal</button>
						<button id="confirmButton" class="px-4 py-2 bg-blue-600 text-white rounded-md">Ya, Simpan</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new TomSelect("#classification_code_id",{
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    });

	document.getElementById('openModalButton').addEventListener('click', function() {
		document.getElementById('confirmationModal').classList.remove('hidden');
	});

	document.getElementById('cancelButton').addEventListener('click', function() {
		document.getElementById('confirmationModal').classList.add('hidden');
	});

	document.getElementById('confirmButton').addEventListener('click', function() {
		document.getElementById('classificationForm').submit(); // Kirim form
	});
</script>

@endpush



@endsection
