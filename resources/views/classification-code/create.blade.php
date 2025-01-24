@extends('layouts.app')

@section('title', 'Tambah Klasifikasi')

@section('content')
    
<div class="p-4 sm:ml-64">
	<h1 class="text-2xl font-bold mb-4 text-txtl">Tambah Data Klasifikasi</h1>
    <form action="{{ route('classification.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block">Kode</label>
            <input type="text" name="code" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Judul</label>
            <input type="text" name="title" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">JRA Aktif</label>
            <input type="number" name="active" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Keterangan JRA Aktif</label>
            <input type="text" name="ket_active" class="w-full p-2 border rounded" required>
        </div>

		<div class="mb-4">
			<label class="block">JRA Inaktif</label>
			<input type="number" name="inactive" class="w-full p-2 border rounded" required>
		</div>

        <div class="mb-4">
            <label class="block">Keterangan JRA Inaktif</label>
            <input type="text" name="ket_inactive" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Keterangan</label>
            <input type="text" name="keterangan" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Klasifikasi Keamanan</label>
            <input type="text" name="security" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block">Hak Akses (Pejabat yang Bertanggung Jawab)</label>
            <input type="text" name="hak_akses" class="w-full p-2 border rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
    
</div>


@push('scripts')
@endpush



@endsection
