@extends('layouts.app')

@section('title', 'Klasifikasi')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-4xl font-bold text-txtl">Klasifikasi Arsip</h1>
		<a href="{{ route('classification.create') }}" class="bg-btn hover:bg-btnh text-txtd px-4 py-2 rounded">Tambah Data</a>
	</div>
	
	<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
		<table class="w-full border mt-4 text-center">
			<thead>
				<tr class="bg-gray-200">
					<th class="p-2 border">No</th>
					<th class="p-2 border">Unit Pengolah</th>
					<th class="p-2 border">Nomor Berkas</th>
					<th class="p-2 border">judul Berkas</th>
					<th class="p-2 border">Nomor Item Berkas</th>
					<th class="p-2 border">Kode Klasifikasi</th>
					<th class="p-2 border">Uraian</th>
					<th class="p-2 border">Kurun Waktu</th>
					<th class="p-2 border">Tahun</th>
					<th class="p-2 border">Jumlah</th>
					<th class="p-2 border">Satuan</th>
					<th class="p-2 border">Tingkat Pengembangan</th>
					<th class="p-2 border">JRA Active</th>
					<th class="p-2 border">JRA Inactive</th>
					<th class="p-2 border">Keterangan</th>
					<th class="p-2 border">Lokasi</th>
					<th class="p-2 border">Klasifikasi Keamanan</th> 
					<th class="p-2 border">Hak Akses</th> 
					<th class="p-2 border">Keterangan Lokasi</th>
					<th class="p-2 border">Tahun Inactive</th>
					<th class="p-2 border">Tahun Pemusnahan</th>
					<th class="p-2 border">Status</th>
					<th class="p-2 border">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($classifications as $classification)
					<tr>
                        <td class="p-2 border">{{ $classifications->firstItem() + $loop->index }}</td>
						<td class="p-2 border">{{ $classification->user->department }}</td>
						<td class="p-2 border">{{ $classification->nomor_berkas }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->title }}</td>
						<td class="p-2 border">{{ $classification->nomor_item_berkas }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->code }}</td>
						<td class="p-2 border">{{ $classification->uraian_berkas }}</td>
						<td class="p-2 border">{{ Carbon::parse($classification->date)->format('d-m-Y') }}</td>
						<td class="p-2 border">{{ Carbon::parse($classification->date)->year }}</td>
						<td class="p-2 border">{{ $classification->jumlah }}</td>
						<td class="p-2 border">{{ $classification->satuan }}</td>
						<td class="p-2 border">{{ $classification->perkembangan }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->active }} tahun {{ $classification->classificationCode->ket_active }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->inactive }} tahun {{ $classification->classificationCode->ket_inactive }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->keterangan }}</td>
						<td class="p-2 border">{{ $classification->lokasi }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->security }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->hak_akses }}</td>
						<td class="p-2 border">{{ $classification->ket_lokasi }}</td>
						<td class="p-2 border">{{ $classification->tahun_inactive }}</td>
						<td class="p-2 border">{{ $classification->tahun_musnah }}</td>
						<td class="p-2 border">{{ $classification->status }}</td>
						<td class="p-2 border">
							<a href="{{ route('classification.edit', $classification->id) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-400 text-txtd px-2 py-1 rounded">Edit</a>
							<button type="button" 
                                    class="deleteButton inline-flex items-center justify-center bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                                    data-id="{{ $classification->id }}">
                                Hapus
                            </button>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<!-- Pagination -->
		<div class="mt-4">
			{{ $classifications->links() }}
		</div>

		<!-- Modal -->
		<div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
			<div class="bg-white rounded-lg shadow-lg p-6">
				<h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
				<p id="modalMessage">Apakah Anda yakin ingin menghapus data ini?</p>
				<div class="flex justify-end mt-4">
					<button id="cancelButton" class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 rounded-md">Batal</button>
					<form id="deleteForm" method="POST">
						@csrf @method('DELETE')
						<button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-md">Ya, Hapus</button>
					</form>
				</div>
			</div>
		</div>
    </div>
</div>


@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("confirmationModal");
        const cancelButton = document.getElementById("cancelButton");
        const modalMessage = document.getElementById("modalMessage");
        const deleteForm = document.getElementById("deleteForm");

        document.querySelectorAll(".deleteButton").forEach(button => {
            button.addEventListener("click", function () {
                const classificationId = this.getAttribute("data-id");
                deleteForm.setAttribute("action", `/classification/${classificationId}`);
                modal.classList.remove("hidden");
            });
        });

        cancelButton.addEventListener("click", function () {
            modal.classList.add("hidden");
        });
    });
</script>
@endpush



@endsection
