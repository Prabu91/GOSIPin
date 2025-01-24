@extends('layouts.app')

@section('title', 'Kode Klasifikasi')

@section('content')
    
<div class="p-4 sm:ml-64">
	<h1 class="text-2xl font-bold mb-4 text-txtl">Kode Klasifikasi</h1>
    <a href="{{ route('classificationCode.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Kode Klasifikasi</a>
    <a href="{{ route('classificationCode.importV') }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Import Kode Klasifikasi</a>
<br><br>
    @if (session('success'))
        <p class="mt-4 text-green-600">{{ session('success') }}</p>
    @endif

    <div class="mt-4">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Kode</th>
                    <th class="p-2 border">Judul</th>
                    <th class="p-2 border">Aktif</th>
                    <th class="p-2 border">Inaktif</th>
                    <th class="p-2 border">Keamanan</th>
                    <th class="p-2 border">Hak Akses</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classificationCodes as $classification)
                    <tr>
                        <td class="p-2 border">{{ $classification->code }}</td>
                        <td class="p-2 border">{{ $classification->title }}</td>
                        <td class="p-2 border">{{ $classification->active }} tahun {{ $classification->ket_active }}</td>
                        <td class="p-2 border">{{ $classification->inactive }} tahun {{ $classification->ket_inactive }}</td>
                        <td class="p-2 border">{{ $classification->security }}</td>
                        <td class="p-2 border">{{ $classification->hak_akses }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('classification.edit', $classification->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <form action="{{ route('classification.destroy', $classification->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $classificationCodes->links() }}
        </div>
    </div>
</div>


@push('scripts')
@endpush



@endsection
