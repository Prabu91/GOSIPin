@extends('layouts.app')

@section('title', 'Arsip Inactive')

@section('content')

@php
	use Carbon\carbon;
@endphp
    
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
	<h1 class="text-4xl font-bold mb-4 text-txtl">Arsip Inactive</h1>

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
					{{-- <th class="p-2 border">Aksi</th> --}}
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
						<td class="p-2 border">{{ $classification->ket_lokasi }}</td>
						<td class="p-2 border">{{ $classification->tahun_inactive }}</td>
						<td class="p-2 border">{{ $classification->tahun_musnah }}</td>
						<td class="p-2 border">{{ $classification->status }}</td>
						{{-- <td class="p-2 border">
							<a href="{{ route('classification.edit', $classification->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
							<form action="{{ route('classification.destroy', $classification->id) }}" method="POST" class="inline">
								@csrf @method('DELETE')
								<button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
							</form>
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
