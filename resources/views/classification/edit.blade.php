@extends('layouts.app')

@section('title', 'Edit Klasifikasi')

@section('content')
    
<div class="container mx-auto max-w-lg p-8 bg-white shadow-md rounded-lg">
	<h1 class="text-2xl font-bold mb-4 text-txtl text-center">Edit Data Klasifikasi</h1>

	<form id="classificationForm" action="{{ route('classification.update', $classification->id) }}" method="POST">
		@csrf
		@method('PUT')
		
		<div class="mb-4">
			<label for="nomor_berkas" class="block">Nomor Berkas</label>
			<input type="number" name="nomor_berkas" id="nomor_berkas" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('nomor_berkas', $classification->nomor_berkas) }}">
			<x-input-error :messages="$errors->get('nomor_berkas')" class="mt-2" />
		</div>
	
		<div class="mb-4">
			<label for="classification_code_id" class="block">Judul Berkas</label>
			<select name="classification_code_id" id="classification_code_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm">
				<option value="">Pilih Judul Berkas</option>
				@foreach($codes as $code)
					<option value="{{ $code->id }}" {{ $classification->classification_code_id == $code->id ? 'selected' : '' }}>
						{{ $code->code }} - {{ $code->title }}
					</option>
				@endforeach
			</select>
		</div>
		
		<div class="mb-4">
			<label for="nomor_item_berkas" class="block">Nomor Item Berkas</label>
			<input type="number" name="nomor_item_berkas" id="nomor_item_berkas" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('nomor_item_berkas', $classification->nomor_item_berkas) }}">
			<x-input-error :messages="$errors->get('nomor_item_berkas')" class="mt-2" />
		</div>
	
		<div class="mb-4">
			<label for="uraian_berkas" class="block">Uraian Berkas</label>
			<input type="text" name="uraian_berkas" id="uraian_berkas" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('uraian_berkas', $classification->uraian_berkas) }}">
			<x-input-error :messages="$errors->get('uraian_berkas')" class="mt-2" />
		</div>
	
		<div class="mb-4">
			<label for="date" class="block">Tanggal</label>
			<input type="date" name="date" id="date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('date', $classification->date) }}">
			<x-input-error :messages="$errors->get('date')" class="mt-2" />
		</div>
	
		<div class="mb-4">
			<label for="jumlah" class="block">Jumlah</label>
			<input type="number" name="jumlah" id="jumlah" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('jumlah', $classification->jumlah) }}">
			<x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
		</div>
	
		<div class="mb-4">
			<label for="satuan" class="block">Satuan</label>
			<input type="text" name="satuan" id="satuan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('satuan', $classification->satuan) }}">
			<x-input-error :messages="$errors->get('satuan')" class="mt-2" />
		</div>
	
		<div class="mb-4">
			<label for="perkembangan" class="block">Tingkat Perkembangan</label>
			<input type="text" name="perkembangan" id="perkembangan" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('perkembangan', $classification->perkembangan) }}">
			<x-input-error :messages="$errors->get('perkembangan')" class="mt-2" />
		</div>
	
		<div class="mb-4">
			<label for="lokasi" class="block">Lokasi</label>
			<select name="lokasi" id="lokasi" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm">
				<option value="rak" {{ $classification->lokasi == 'rak' ? 'selected' : '' }}>Rak</option>
				<option value="shelf" {{ $classification->lokasi == 'shelf' ? 'selected' : '' }}>Shelf</option>
				<option value="box" {{ $classification->lokasi == 'box' ? 'selected' : '' }}>Box</option>
			</select>
		</div>
		
		<div class="mb-4">
			<label for="box_number" class="block">Nomor Box</label>
			<input type="text" name="box_number" id="box_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm sm:text-sm" value="{{ old('box_number', $classification->box_number) }}">
			<x-input-error :messages="$errors->get('box_number')" class="mt-2" />
		</div>
	
		<div class="flex justify-end items-center">
			<button type="button" id="openModalButton" class="bg-btn hover:bg-btnh text-txtd px-4 py-2 rounded">Update</button>
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
