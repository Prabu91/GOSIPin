@extends('layouts.app')

@section('title', 'Klasifikasi')

@section('content')
    
<div class="p-4 sm:ml-64">
	<h1 class="text-2xl font-bold mb-4 text-txtl">Klasifikasi</h1>
    <form action="{{ route('classification.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="file" class="block">Upload File Excel</label>
            <input type="file" name="import_klasifikasi" id="file" class="w-full p-2 border rounded" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
    </form>
</div>


@push('scripts')
@endpush



@endsection
