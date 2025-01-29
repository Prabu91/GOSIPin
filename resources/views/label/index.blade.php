@extends('layouts.app')

@section('title', 'Label Box')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
	<div class="flex items-center justify-between mb-6">
		<h1 class="text-4xl font-bold text-txtl">Label Box</h1>
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
								<a href="{{ route('labelBox.editRak', $classification->id) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-400 text-txtd px-2 py-1 rounded">Nomor Rak</a>
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
