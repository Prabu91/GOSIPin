<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function index(Request $request)
    // {
    //     $tahun = $request->get('tahun') ?? now()->year;

    //     $data = [];
    //     $departments = ['PMU', 'YANFASKES', 'YANSER', 'KEPSER', 'PKP', 'SDMUK'];

    //     $chartData = [
    //         'labels' => $departments,
    //         'active' => [],
    //         'inactive' => []
    //     ];

    //     $totalAktif = 0;
    //     $totalInaktif = 0;

    //     foreach ($departments as $dept) {
    //         $activeArsip = Classification::where('bagian', $dept)
    //             ->where('status', 'aktif')
    //             ->whereYear('created_at', $tahun)
    //             ->count();

    //         $inactiveArsip = Classification::where('bagian', $dept)
    //             ->where('status', 'inaktif')
    //             ->whereYear('created_at', $tahun)
    //             ->count();

    //         $data[$dept] = [
    //             'aktif' => $activeArsip,
    //             'inaktif' => $inactiveArsip,
    //         ];

    //         $chartData['active'][] = $activeArsip;
    //         $chartData['inactive'][] = $inactiveArsip;

    //         $totalAktif += $activeArsip;
    //         $totalInaktif += $inactiveArsip;
    //     }

    //     $availableYears = Classification::selectRaw('YEAR(created_at) as year')
    //         ->distinct()
    //         ->orderBy('year', 'desc')
    //         ->pluck('year');

    //     return view('dashboard', compact(
    //         'data',
    //         'chartData',
    //         'totalAktif',
    //         'totalInaktif',
    //         'availableYears'
    //     ));
    // }

    public function index(Request $request)
    {
        $allDepartments = ['PMU', 'YANFASKES', 'YANSER', 'KEPSER', 'PKP', 'SDMUK'];

        $selectedYear = $request->input('tahun');
        $selectedDept = $request->input('bagian');

        $grandTotalAktif = Classification::where('status', 'Aktif')->count();
        $grandTotalInaktif = Classification::where('status', 'Inaktif')->count();


        // Ambil semua tahun unik dari kolom `date`
        $years = Classification::whereNotNull('date')
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Filter departemen yang ditampilkan
        $filteredDepartments = $selectedDept ? [$selectedDept] : $allDepartments;

        // Hitung jumlah arsip aktif & inaktif per departemen
        $data = [];
        $totalAktif = 0;
        $totalInaktif = 0;

        foreach ($filteredDepartments as $dept) {
            $aktif = Classification::where('bagian', $dept)
                        ->when($selectedYear, fn($q) => $q->whereYear('date', $selectedYear))
                        ->where('status', 'Aktif')
                        ->count();

            $inaktif = Classification::where('bagian', $dept)
                        ->when($selectedYear, fn($q) => $q->whereYear('date', $selectedYear))
                        ->where('status', 'Inaktif')
                        ->count();

            $data[$dept] = [
                'aktif' => $aktif,
                'inaktif' => $inaktif,
            ];

            $totalAktif += $aktif;
            $totalInaktif += $inaktif;
        }

        // Ambil data untuk chart (filter berdasarkan bagian)
        $chartQuery = Classification::selectRaw('YEAR(date) as year, status, COUNT(*) as total')
            ->when($selectedDept, fn($q) => $q->where('bagian', $selectedDept))
            ->groupBy('year', 'status')
            ->orderBy('year')
            ->get();

        $chartLabels = $years;
        $activeData = [];
        $inactiveData = [];

        foreach ($chartLabels as $year) {
            $active = $chartQuery->firstWhere(fn($item) => $item->year == $year && $item->status == 'Aktif');
            $inactive = $chartQuery->firstWhere(fn($item) => $item->year == $year && $item->status == 'Inaktif');
            $activeData[] = $active ? $active->total : 0;
            $inactiveData[] = $inactive ? $inactive->total : 0;
        }

        $chartData = [
            'labels' => $chartLabels,
            'active' => $activeData,
            'inactive' => $inactiveData,
        ];

        return view('dashboard', [
            'data' => $data,
            'chartData' => $chartData,
            'years' => $years,
            'departments' => $allDepartments, // tetap semua, untuk dropdown
            'selectedYear' => $selectedYear,
            'selectedDept' => $selectedDept,
            'totalAktif' => $totalAktif,
            'totalInaktif' => $totalInaktif,
            'grandTotalAktif' => $grandTotalAktif,
            'grandTotalInaktif' => $grandTotalInaktif
        ]);
    }



}
