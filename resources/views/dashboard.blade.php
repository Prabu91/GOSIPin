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
                    <p class="text-lg font-bold text-green-600">{{ $data[$dept]['aktif'] }}</p>
                </div>

                <!-- Arsip Inaktif -->
                <div class="w-1/2 text-center pl-2">
                    <h3 class="text-sm font-semibold">Arsip Inaktif</h3>
                    <p class="text-lg font-bold text-red-600">{{ $data[$dept]['inaktif'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Chart Section -->
<div class="mt-8 bg-white shadow-md rounded-lg p-4">
    <h2 class="text-lg font-semibold text-center mb-4">Perbandingan Arsip Aktif dan Inaktif per Bagian</h2>
    <canvas id="statusChart"></canvas>
</div>


@push('scripts')
<script>
    var ctx = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(ctx, {
        type: 'bar', // Tipe chart: bar chart
        data: {
            labels: @json($chartData['labels']), // Departemen sebagai label
            datasets: [{
                label: 'Arsip Aktif',
                data: @json($chartData['active']), // Data arsip aktif
                backgroundColor: 'rgba(34, 197, 94, 0.5)', // Warna background bar
                borderColor: 'rgba(34, 197, 94, 1)', // Warna border
                borderWidth: 1
            }, {
                label: 'Arsip Inaktif',
                data: @json($chartData['inactive']), // Data arsip inaktif
                backgroundColor: 'rgba(239, 68, 68, 0.5)', // Warna background bar
                borderColor: 'rgba(239, 68, 68, 1)', // Warna border
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush



@endsection
