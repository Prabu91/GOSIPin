@extends('layouts.app')

@section('title', 'Arsip Inaktif')

@section('content')

@php
	use Carbon\carbon;
@endphp
    

{{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
	<div class="bg-white shadow-md rounded-lg p-4">
		<h2 class="text-lg font-semibold text-center mb-4">Total Arsip Inaktif</h2>
		<div class="flex">
			<div class="w-1/3 text-center pr-2 border-r">
				<h3 class="text-sm font-semibold">Penghapusan</h3>
				<p class="text-lg font-bold">{{ $classificationCounts->get('Box Dihapuskan', 0) }}</p>
			</div>
			<div class="w-1/3 text-center pl-2">
				<h3 class="text-sm font-semibold">Diajukan Penghapusan</h3>
				<p class="text-lg font-bold">{{ $classificationCounts->get('Box Diajukan Penghapusan', 0) }}</p>
			</div>
			<div class="w-1/3 text-center pl-2">
				<h3 class="text-sm font-semibold">Belum Diajukan</h3>
				<p class="text-lg font-bold">{{ $classificationCounts->get('Box Belum Dihapuskan', 0) }}</p>
			</div>
		</div>
	</div>
	
	<div class="bg-white shadow-md rounded-lg p-4">
		<h2 class="text-lg font-semibold text-center mb-4">Total Penghapusan Arsip</h2>
		<div class="flex">
			@for ($i = 1; $i <= 6; $i++)
				<div class="w-1/6 text-center pr-2 border-r">
					<h3 class="text-sm font-semibold">Tahap {{ $i }}</h3>
					<p class="text-lg font-bold">{{ $statusCounts->get('Tahap '.$i, 0) }}</p>
				</div>
			@endfor
		</div>
	</div>
	
</div> --}}

<!-- Data Table -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
	<div class="bg-white shadow-md rounded-lg p-4">
		<form method="GET" action="{{ route('classification.inactive') }}">
			<h2 class="text-lg font-semibold text-center mb-4">Total Arsip Inaktif</h2>
			<div class="flex">
				<div class="w-1/3 text-center pr-2">
					<button type="submit" name="klasifikasi_box" value="Box Dihapuskan" class="text-sm font-semibold text-txtl hover:text-txtd hover:border-btnh hover:bg-btnh p-3 rounded-lg
					@if(request('klasifikasi_box') == 'Box Dihapuskan') border-2 border-btn @endif ">
						Penghapusan
					</button>
					<p class="text-lg font-bold">{{ $classificationCounts->get('Box Dihapuskan', 0) }}</p>
				</div>
				<div class="w-1/3 text-center pl-2">
					<button type="submit" name="klasifikasi_box" value="Box Diajukan Penghapusan" class="text-sm font-semibold text-txtl hover:text-txtd hover:border-btnh hover:bg-btnh p-1 rounded-lg
					@if(request('klasifikasi_box') == 'Box Diajukan Penghapusan') border-2 border-btn @endif">
						Diajukan Penghapusan
					</button>
					<p class="text-lg font-bold">{{ $classificationCounts->get('Box Diajukan Penghapusan', 0) }}</p>
				</div>
				<div class="w-1/3 text-center pl-2">
					<button type="submit" name="klasifikasi_box" value="Box Belum Dihapuskan" class="text-sm font-semibold text-txtl hover:text-txtd hover:border-btnh hover:bg-btnh p-3 rounded-lg 
					@if(request('klasifikasi_box') == 'Box Belum Dihapuskan') border-2 border-btn @endif">
						Belum Diajukan
					</button>
					<p class="text-lg font-bold">{{ $classificationCounts->get('Box Belum Dihapuskan', 0) }}</p>
				</div>
			</div>
		</form>
	</div>
		
	<div class="bg-white shadow-md rounded-lg p-4">
		<form method="GET" action="{{ route('classification.inactive') }}">
			<h2 class="text-lg font-semibold text-center mb-4">Total Penghapusan Arsip</h2>
			<div class="flex">
				@for ($i = 1; $i <= 6; $i++)
				<div class="w-1/6 text-center pr-2 border-r">
					<button type="submit" name="status_box" value="Tahap {{ $i }}" class="text-sm font-semibold text-txtl hover:text-txtd hover:border-btnh hover:bg-btnh p-1 rounded-lg
					@if(request('status_box') == "Tahap {$i}") border-2 border-btn @endif">
						Tahap {{ $i }}
					</button>
					<p class="text-lg font-bold">{{ $statusCounts->get('Tahap '.$i, 0) }}</p>
				</div>
				@endfor
			</div>
		</form>
	</div>
</div>


<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-4xl font-bold text-txtl">Arsip Inaktif</h1>
        <div class="flex items-center">
			<form class="w-64" method="GET" action="{{ route('classification.inactive') }}">
				<label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">
					Search
				</label>
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
			<form method="GET" class=" mx-4"action="{{ route('classification.inactive') }}">
				<button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-400">Reset Filter</button>
			</form>
			<a href="{{ route('classification.exportInaktif') }}" class="bg-green-500 hover:bg-green-400 text-white px-2 py-1 rounded-lg">
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
						<td class="p-2 border font-bold text-red-600">{{ $classification->status }}</td>
						<td class="p-2 border bg-gray-300 font-bold">{{ $classification->klasifikasi_box }}</td>
						<td class="p-2 border bg-gray-300">
							@if ($classification->status_box !== '-')
							<span class="font-bold">{{ $classification->status_box }}</span>
							@elseif ($classification->tahun_musnah < now()->year)
								<span class="font-bold text-green-600">Bisa Dimusnahkan</span>
							@elseif($classification->tahun_musnah >= now()->year){
								<span class="font-bold text-red-600">Belum Bisa Dimusnahkan</span>
							}
							@endif
						</td>						
						<td class="p-2 border text-center">
							<div class="flex justify-center space-x-2">
								<a href="{{ route('classification.editBox', $classification->id) }}" class="bg-btn hover:bg-btnh text-txtd px-2 py-1 rounded text-sm">
									Klasifikasi Box
								</a>
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
    </div>
</div>


@push('scripts')
@endpush



@endsection
