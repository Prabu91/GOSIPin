@extends('layouts.app')

@section('title', 'Rak Box')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto max-w-xl p-8 bg-white shadow-md rounded-lg">
	<h1 class="text-2xl font-bold mb-4 text-txtl text-center">Nomor Rak</h1>

	<table class="w-full border my-4">
		<tbody>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Nomor Box</th>
				<td class="p-2 border">{{ $classification->box_number }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Unit Pengolah</th>
				<td class="p-2 border">{{ $classification->user->department }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Uraian</th>
				<td class="p-2 border">{{ $classification->uraian_berkas }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Kode Klasifikasi</th>
				<td class="p-2 border">{{ $classification->classificationCode->code }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Tahun</th>
				<td class="p-2 border">{{ Carbon::parse($classification->date)->year }}</td>
			</tr>
		</tbody>
	</table>
	

	<form id="labelRakForm" action="{{ route('labelBox.updateRak', $classification->id) }}" method="POST" class="mt-8">
		@csrf
		@method('PUT')
		
		<div class="mb-4">
			<div class="mb-4">
				<label class="block">Nomor Rak</label>
				<input type="text" name="rak_number" class="w-full p-2 border rounded">
				<x-input-error :messages="$errors->get('rak_number')" class="mt-1 text-red-500 text-sm" />
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
	document.getElementById('openModalButton').addEventListener('click', function() {
		document.getElementById('confirmationModal').classList.remove('hidden');
	});

	document.getElementById('cancelButton').addEventListener('click', function() {
		document.getElementById('confirmationModal').classList.add('hidden');
	});

	document.getElementById('confirmButton').addEventListener('click', function() {
		document.getElementById('labelRakForm').submit(); // Kirim form
	});
</script>

@endpush



@endsection
