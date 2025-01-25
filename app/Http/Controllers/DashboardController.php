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

        foreach ($departments as $dept) {
            $activeArsip = Classification::where('bagian', $dept)->where('status', 'active')->count();
            $inactiveArsip = Classification::where('bagian', $dept)->where('status', 'inactive')->count();

            $data[$dept] = [
                'active' => $activeArsip,
                'inactive' => $inactiveArsip,
            ];
        }

        return view('dashboard', compact('data'));
    }
}
