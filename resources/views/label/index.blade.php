@extends('layouts.app')

@section('title', 'Label Box')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-4xl font-bold text-txtl">Label Box</h1>
		<div class="flex items-center">
			<form class="w-64 mx-4" method="GET" action="{{ route('classification.index') }}">
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
			<a href="{{ route('labelBox.exportData') }}" class="bg-green-500 hover:bg-green-400 text-white px-2 py-1 rounded-lg">
				Export to Excel
			</a>
		</div>
	</div>
	
	<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
		<table class="w-full border mt-4 text-center">
			<thead>
				<tr class="bg-gray-200">
					<th class="p-2 border">No</th>
					<th class="p-2 border">Nomor Box</th>
					<th class="p-2 border">Unit Pengolah</th>
					<th class="p-2 border">Uraian</th>
					<th class="p-2 border">Kode Klasifikasi</th>
					<th class="p-2 border">Tahun</th>
					<th class="p-2 border">No. Rak</th>
					<th class="p-2 border">Status</th>
					<th class="p-2 border">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($classifications as $classification)
					<tr>
                        <td class="p-2 border">{{ $classifications->firstItem() + $loop->index }}</td>
						<td class="p-2 border">{{ $classification->box_number }}</td>
						<td class="p-2 border">{{ $classification->user->department }}</td>
						<td class="p-2 border">{{ $classification->uraian_berkas }}</td>
						<td class="p-2 border">{{ $classification->classificationCode->code }}</td>
						<td class="p-2 border">{{ Carbon::parse($classification->date)->year }}</td>
						<td class="p-2 border">{{ $classification->rak_number ?? '-' }}</td>
						<td class="p-2 border font-bold text-{{ $classification->status == 'Aktif' ? 'green-600' : 'red-600' }}">
							{{ $classification->status }}
						</td>
						<td class="p-2 border text-center">
							<div class="flex justify-center space-x-2">
								<a href="{{ route('labelBox.editRak', $classification->id) }}" class="inline-flex items-center justify-center bg-btn hover:bg-btnh text-txtd px-2 py-1 rounded">Nomor Rak</a>
								<a href="{{ route('labelBox.export', $classification->id) }}" class="inline-flex items-center justify-center bg-green-500 hover:bg-green-400 text-txtd px-2 py-1 rounded">Print Label</a>
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
