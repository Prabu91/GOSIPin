<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $departments = ['PMU', 'YANFASKES', 'YANSER', 'KEPSER', 'PKP', 'SDMUK'];

        // Data untuk chart
        $chartData = [
            'labels' => $departments, // Label untuk chart (nama-nama bagian)
            'active' => [], // Data untuk arsip aktif
            'inactive' => [] // Data untuk arsip inaktif
        ];


        foreach ($departments as $dept) {
            $activeArsip = Classification::where('bagian', $dept)->where('status', 'aktif')->count();
            $inactiveArsip = Classification::where('bagian', $dept)->where('status', 'inaktif')->count();

            $data[$dept] = [
                'aktif' => $activeArsip,
                'inaktif' => $inactiveArsip,
            ];

            // Menambahkan data untuk chart
            $chartData['active'][] = $activeArsip;
            $chartData['inactive'][] = $inactiveArsip;
        }

        return view('dashboard', compact('data', 'chartData'));
    }
}
