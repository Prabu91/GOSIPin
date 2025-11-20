@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4 flex gap-4 flex-wrap items-center">
    <form method="GET" class="flex items-center gap-2">
        <label for="tahun" class="text-sm font-medium">Tahun:</label>
        <select name="tahun" id="tahun" class="border rounded px-2 py-1">
            <option value="">Semua</option>
            @foreach ($years as $year)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>

        <label for="bagian" class="text-sm font-medium">Bagian:</label>
        <select name="bagian" id="bagian" class="border rounded px-2 py-1">
            <option value="">Semua</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept }}" {{ $selectedDept == $dept ? 'selected' : '' }}>{{ $dept }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Filter</button>
    </form>
</div>

<div class="mb-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
    <!-- Total Arsip (yang terfilter) -->
    <div class="bg-white rounded-lg shadow p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="text-md font-semibold">Total Arsip</h3>
            <p class="text-sm text-gray-600">
                {{ $selectedYear ? 'Tahun ' . $selectedYear : 'Semua Tahun' }} |
                {{ $selectedDept ? 'Bagian ' . $selectedDept : 'Semua Bagian' }}
            </p>
        </div>
        <div class="flex gap-6 text-center">
            <div>
                <p class="text-sm text-gray-600">Aktif</p>
                <p class="text-lg font-bold text-green-600">{{ $totalAktif }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Inaktif</p>
                <p class="text-lg font-bold text-red-600">{{ $totalInaktif }}</p>
            </div>
        </div>
    </div>

    <!-- Total Keseluruhan -->
    <div class="bg-white rounded-lg shadow p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="text-md font-semibold">Total Keseluruhan</h3>
            <p class="text-sm text-gray-600">Semua Tahun & Semua Bagian</p>
        </div>
        <div class="flex gap-6 text-center">
            <div>
                <p class="text-sm text-gray-600">Aktif</p>
                <p class="text-lg font-bold text-green-600">{{ $grandTotalAktif }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Inaktif</p>
                <p class="text-lg font-bold text-red-600">{{ $grandTotalInaktif }}</p>
            </div>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach ($data as $dept => $counts)
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold text-center mb-4">{{ $dept }}</h2>
            <div class="flex">
                <div class="w-1/2 text-center pr-2 border-r">
                    <h3 class="text-sm font-semibold">Arsip Aktif</h3>
                    <p class="text-lg font-bold text-green-600">{{ $counts['aktif'] }}</p>
                </div>
                <div class="w-1/2 text-center pl-2">
                    <h3 class="text-sm font-semibold">Arsip Inaktif</h3>
                    <p class="text-lg font-bold text-red-600">{{ $counts['inaktif'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Chart -->
<div class="mt-8 bg-white shadow-md rounded-lg p-4">
    <h2 class="text-lg font-semibold text-center mb-4">Perbandingan Arsip Aktif dan Inaktif per Tahun</h2>
    <canvas id="statusChart" width="400" height="200"></canvas>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartLabels = @json($chartData['labels']);
    const chartDataAktif = @json($chartData['active']);
    const chartDataInaktif = @json($chartData['inactive']);

    console.log("Labels:", chartLabels);
    console.log("Aktif:", chartDataAktif);
    console.log("Inaktif:", chartDataInaktif);

    const ctx = document.getElementById('statusChart').getContext('2d');

    if (chartLabels.length) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Arsip Aktif',
                        data: chartDataAktif,
                        backgroundColor: 'rgba(34, 197, 94, 0.5)',
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Arsip Inaktif',
                        data: chartDataInaktif,
                        backgroundColor: 'rgba(239, 68, 68, 0.5)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    } else {
        console.warn("Chart data kosong. Tidak menampilkan chart.");
    }
</script>
@endpush
