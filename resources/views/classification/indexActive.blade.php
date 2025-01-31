@extends('layouts.app')

@section('title', 'Arsip Aktif')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-4xl font-bold mb-4 text-txtl">Arsip Aktif</h1>
		<div class="flex items-center">
			<form class="w-64" method="GET" action="{{ route('classification.active') }}">
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
			<a href="{{ route('classification.exportAktif') }}" class="bg-green-500 hover:bg-green-400 text-white px-2 py-1 rounded-lg">
				Export to Excel
			</a>
		</div>
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
					<th class="p-2 border">Klasifikasi Box</th>
					<th class="p-2 border">Status Box</th>
					{{-- <th class="p-2 border">Aksi</th> --}}
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
					<td class="p-4 border">{{ Carbon::parse($classification->date)->format('d-m-Y') }}</td>
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
					<td class="p-2 border font-bold text-green-600">{{ $classification->status }}</td>
					<td class="p-2 border bg-gray-300 font-bold">{{ $classification->klasifikasi_box }}</td>
					<td class="p-2 border bg-gray-300">
						@if ($classification->status_box !== '-')
						<span class="font-bold">{{ $classification->status_box }}</span>
						@elseif ($classification->tahun_musnah < now()->year)
							<span class="font-bold text-green-600">Bisa Dimusnahkan</span>
						@elseif($classification->tahun_musnah >= now()->year)
							<span class="font-bold text-red-600">Belum Bisa Dimusnahkan</span>
						@endif
					</td>						
					{{-- <td class="p-2 border text-center">
						<div class="flex justify-center space-x-2">
							<a href="{{ route('classification.editBox', $classification->id) }}" class="bg-btn hover:bg-btnh text-txtd px-2 py-1 rounded text-sm">
								Klasifikasi Box
							</a>
						</div>
					</td> --}}
		
				</tr>
				@endforeach
			</tbody>
		</table>

		<!-- Pagination -->
		<div class="mt-4">
			{{ $classifications->links() }}
		</div>
    </div>
</div>


@push('scripts')
@endpush



@endsection
