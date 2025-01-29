@extends('layouts.app')

@section('title', 'Klasifikasi')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-4xl font-bold text-txtl">Klasifikasi Arsip</h1>
		<form class="w-64" method="GET" action="{{ route('classification.index') }}">
			<label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
			<div class="relative">
				<div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
					<svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
					</svg>
				</div>
				<input 
					type="search" 
					id="search" 
					name="search" 
					value="{{ request('search') }}" 
					class="block w-full p-2 ps-10 text-sm text-txtl border border-gray-300 rounded-lg bg-gray-50 focus:ring-btnh focus:border-btnh" 
					placeholder="Cari kode/judul..."  
				/>
				<button type="submit" class="text-txtd absolute end-2 bottom-1 bg-btn hover:bg-btnh focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-3 py-1">
					Search
				</button>
			</div>
		</form>
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
					<th class="p-2 border">JRA Aktif</th>
					<th class="p-2 border">JRA Inaktif</th>
					<th class="p-2 border">Keterangan</th>
					<th class="p-2 border">Lokasi</th>
					<th class="p-2 border">Klasifikasi Keamanan</th> 
					<th class="p-2 border">Hak Akses</th> 
					<th class="p-2 border">Nomor Box</th>
					<th class="p-2 border">Tahun Inaktif</th>
					<th class="p-2 border">Tahun Pemusnahan</th>
					<th class="p-2 border">Status</th>
					<th class="p-2 border">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($classifications as $classification)
					<tr>
                        <td class="p-2 border">{{ $classifications->firstItem() + $loop->index }}</td>
						<td class="p-2 border">{{ $classification->bagian }}</td>
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
						<td class="p-2 border">{{ $classification->box_number }}</td>
						<td class="p-2 border">{{ $classification->tahun_inactive }}</td>
						<td class="p-2 border">{{ $classification->tahun_musnah }}</td>
						<td class="p-2 border font-bold text-{{ $classification->status == 'Aktif' ? 'green-600' : 'red-600' }}">
							{{ $classification->status }}
						</td>
						<td class="p-2 border text-center">
							<div class="flex justify-center space-x-2">
								<a href="{{ route('classification.edit', $classification->id) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-400 text-txtd px-2 py-1 rounded">Edit</a>
								<button type="button" 
										class="deleteButton inline-flex items-center justify-center bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
										data-id="{{ $classification->id }}">
									Hapus
								</button>
							</div>
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
