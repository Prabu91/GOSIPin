<?php

namespace App\Http\Controllers;

use App\Models\Classification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\LabelExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LabelBoxController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Classification::query();

        if ($user->role === 'UP') {
            $query->where('bagian', $user->department); 
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                if (in_array(strtolower($search), ['aktif', 'inaktif'])) {
                    $q->where('status', $search);
                } else {
                    $q->whereHas('classificationCode', function ($q) use ($search) {
                        $q->where('code', 'like', "%$search%");
                    })->orWhere('box_number', 'like', "%$search%");
                }
            });
        }

        $classifications = $query->orderBy('box_number', 'asc')->paginate(10);

        return view('label.index', compact('classifications'));
    }


    public function editRak($id) {
        $classification = Classification::findOrFail($id);

        return view('label.edit-rak', compact('classification'));
    }

    public function updateRak(Request $request, $id) {
        try {
            DB::transaction(function () use ($request, $id) {
                $classification = Classification::findOrFail($id);
    
                $classification->update([
                    'rak_number' => $request->rak_number,
                ]);
            });
    
            return redirect()->route('labelBox.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('labelBox.index')->with('error', 'Gagal Memperbarui Data!');
        }
    }

    public function exportPdf($id)
    {
        $classification = Classification::findOrFail($id);
        $year = Carbon::parse($classification->date)->year;

        if ($classification->bagian == 'PMU') {
            $bagian = 'Penjamin Manfaat dan Utilitas';
        } elseif ($classification->bagian == 'PKP') {
            $bagian = 'Pemeriksaan, Keuangan dan Perencanaan';
        }elseif ($classification->bagian == 'YANSER') {
            $bagian = 'Pelayanan Peserta';
        }elseif ($classification->bagian == 'YANFASKES') {
            $bagian = 'Pelayanan Fasilitas Kesehatan';
        }elseif ($classification->bagian == 'SDMUK') {
            $bagian = 'SDM, Umum, dan Komunikasi';
        } else {
            $bagian = 'Kepesertaan';
        }
        

        $pdf = Pdf::loadView('label.export-label', compact('classification', 'year', 'bagian'));

        return $pdf->download('Box-'.$classification->box_number.'.pdf');
    }

    public function exportLabel(Request $request)
    {
        return Excel::download(new LabelExport, 'data_labels.xlsx');
    }

}
