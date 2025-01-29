@extends('layouts.app')

@section('title', 'Klasifikasi Box')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto max-w-xl p-8 bg-white shadow-md rounded-lg">
	<h1 class="text-2xl font-bold mb-4 text-txtl text-center">Status Pemusnahan Box</h1>

	<table class="w-full border my-4">
		<tbody>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Unit Pengolah</th>
				<td class="p-2 border">{{ $classification->user->department }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Nomor Berkas</th>
				<td class="p-2 border">{{ $classification->nomor_berkas }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Judul Berkas</th>
				<td class="p-2 border">{{ $classification->classificationCode->title }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Nomor Item Berkas</th>
				<td class="p-2 border">{{ $classification->nomor_item_berkas }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Kode Klasifikasi</th>
				<td class="p-2 border">{{ $classification->classificationCode->code }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Uraian</th>
				<td class="p-2 border">{{ $classification->uraian_berkas }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Kurun Waktu</th>
				<td class="p-2 border">{{ Carbon::parse($classification->date)->format('d-m-Y') }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Tahun</th>
				<td class="p-2 border">{{ Carbon::parse($classification->date)->year }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Jumlah</th>
				<td class="p-2 border">{{ $classification->jumlah }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Satuan</th>
				<td class="p-2 border">{{ $classification->satuan }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Tingkat Pengembangan</th>
				<td class="p-2 border">{{ $classification->perkembangan }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">JRA Aktif</th>
				<td class="p-2 border">{{ $classification->classificationCode->active }} tahun {{ $classification->classificationCode->ket_active }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">JRA Inaktif</th>
				<td class="p-2 border">{{ $classification->classificationCode->inactive }} tahun {{ $classification->classificationCode->ket_inactive }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Lokasi</th>
				<td class="p-2 border">{{ $classification->lokasi }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Nomor Box</th>
				<td class="p-2 border">{{ $classification->box_number }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Tahun Inaktif</th>
				<td class="p-2 border">{{ $classification->tahun_inactive }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Tahun Pemusnahan</th>
				<td class="p-2 border">{{ $classification->tahun_musnah }}</td>
			</tr>
			<tr>
				<th class="p-2 border text-left bg-gray-200">Status Arsip</th>
				<td class="p-2 border">{{ $classification->status }}</td>
			</tr>
		</tbody>
	</table>
	

	<form id="classificationForm" action="{{ route('classification.updateBox', $classification->id) }}" method="POST" class="mt-8">
		@csrf
		@method('PUT')
		
		<div class="mb-4">
			<label for="klasifikasi_box" class="block">Klasifikasi Box</label>
			<select name="klasifikasi_box" id="klasifikasi_box" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm">
				<option value="Box Belum Dihapuskan" {{ $classification->klasifikasi_box == 'Box Belum Dihapuskan' ? 'selected' : '' }}>Box Belum Dihapuskan</option>
				<option value="Box Diajukan Penghapusan" {{ $classification->klasifikasi_box == 'Box Diajukan Penghapusan' ? 'selected' : '' }}>Box Diajukan Penghapusan</option>
				<option value="Box Dihapuskan" {{ $classification->klasifikasi_box == 'Box Dihapuskan' ? 'selected' : '' }}>Box Dihapuskan</option>
			</select>
			<x-input-error :messages="$errors->get('klasifikasi_box')" class="mt-1 text-red-500 text-sm" />
			</div>
			
			<div class="mb-4">
				<label for="status_box" class="block">Status Box</label>
				<select name="status_box" id="status_box" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm">
					<option value="-" {{ $classification->status_box == '-' ? 'selected' : '' }}>Default (-)</option>
				<option value="Tahap 1" {{ $classification->status_box == 'Tahap 1' ? 'selected' : '' }}>Tahap 1</option>
				<option value="Tahap 2" {{ $classification->status_box == 'Tahap 2' ? 'selected' : '' }}>Tahap 2</option>
				<option value="Tahap 3" {{ $classification->status_box == 'Tahap 3' ? 'selected' : '' }}>Tahap 3</option>
				<option value="Tahap 4" {{ $classification->status_box == 'Tahap 4' ? 'selected' : '' }}>Tahap 4</option>
				<option value="Tahap 5" {{ $classification->status_box == 'Tahap 5' ? 'selected' : '' }}>Tahap 5</option>
				<option value="Tahap 6" {{ $classification->status_box == 'Tahap 6' ? 'selected' : '' }}>Tahap 6</option>
			</select>
			<x-input-error :messages="$errors->get('status_box')" class="mt-1 text-red-500 text-sm" />
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
		document.getElementById('classificationForm').submit(); // Kirim form
	});
</script>

@endpush



@endsection
