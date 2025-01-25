@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach (['PMU', 'YANFASKES', 'YANSER', 'KEPSER', 'PKP', 'SDMUK'] as $dept)
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-center mb-4">{{ $dept }}</h2>
            
            <div class="flex">
                <!-- Arsip Aktif -->
                <div class="w-1/2 text-center pr-2 border-r">
                    <h3 class="text-sm font-semibold">Arsip Aktif</h3>
                    <p class="text-lg font-bold text-green-600">{{ rand(10, 100) }}</p>
                </div>

                <!-- Arsip Inaktif -->
                <div class="w-1/2 text-center pl-2">
                    <h3 class="text-sm font-semibold">Arsip Inaktif</h3>
                    <p class="text-lg font-bold text-red-600">{{ rand(5, 50) }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>


@push('scripts')
@endpush



@endsection
