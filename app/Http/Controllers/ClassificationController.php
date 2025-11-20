<?php

namespace App\Http\Controllers;

use App\Exports\AktifExport;
use App\Exports\InaktifExport;
use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;
use App\Imports\ClassificationImport;
use App\Models\Classification;
use App\Models\ClassificationCode;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
                        $q->where('code', 'like', "%$search%")
                            ->orWhere('title', 'like', "%$search%");
                    })->orWhere('box_number', 'like', "%$search%");
                }
            });
        }

        $classifications = $query->orderBy('date', 'asc')->paginate(10);

        return view('classification.index', compact('classifications'));
    }



    public function indexActive(Request $request)
    {
        $user = Auth::user();
        $query = Classification::where('status', 'aktif');
        if ($user->role === 'UP') {
            $query->where('bagian', $user->department);
        }
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('classificationCode', function ($q) use ($search) {
                    $q->where('code', 'like', "%$search%")
                        ->orWhere('title', 'like', "%$search%");
                })
                ->orWhere('box_number', 'like', "%{$search}%");
            });
        }

        $classifications = $query->orderBy('box_number', 'asc')->paginate(50);

        return view('classification.indexActive', compact('classifications'));
    }


    public function indexInactive(Request $request)
    {
        $user = Auth::user();
        $query = Classification::with('classificationCode', 'user')->where('status', 'inaktif');

        if ($user->role === 'UP') {
            $query->where('bagian', $user->department);
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('classificationCode', function ($q) use ($search) {
                    $q->where('code', 'like', "%$search%")
                        ->orWhere('title', 'like', "%$search%");
                })
                ->orWhere('box_number', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan klasifikasi_box
        if ($request->has('klasifikasi_box')) {
            $query->where('klasifikasi_box', $request->input('klasifikasi_box'));
        }

        // Filter berdasarkan status_box
        if ($request->has('status_box')) {
            $query->where('status_box', $request->input('status_box'));
        }

        if ($request->has('tahun')) {
            $tahun = $request->input('tahun');
            $query->whereRaw('YEAR(date) = ?', [$tahun]);
        }        

        // Ambil data berdasarkan query yang telah difilter
        $classifications = $query
            ->orderByRaw('status_box IS NOT NULL') // NULL duluan
            ->orderBy('box_number', 'desc')         // baru urutkan box_number
            ->paginate(50);

        // Query untuk menghitung jumlah berdasarkan klasifikasi_box yang ikut terfilter tahun
        $classificationCounts = Classification::where('status', 'inaktif')
            ->when($user->role === 'UP', function ($q) use ($user) {
                return $q->where('bagian', $user->department);
            })
            ->when($request->has('tahun'), function ($q) use ($request) {
                return $q->where('tahun_inactive', $request->input('tahun'));
            })
            ->get()
            ->groupBy('klasifikasi_box')
            ->map(fn ($items) => $items->count());

        // Query untuk menghitung jumlah berdasarkan status_box yang ikut terfilter tahun
        $statusCounts = Classification::where('status', 'inaktif')
            ->when($user->role === 'UP', function ($q) use ($user) {
                return $q->where('bagian', $user->department);
            })
            ->when($request->has('tahun'), function ($q) use ($request) {
                return $q->where('date', $request->input('tahun'));
            })
            ->get()
            ->groupBy('status_box')
            ->map(fn ($items) => $items->count());

        // Ambil tahun unik dari kolom 'date'
        $years = Classification::whereNotNull('date')
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('classification.indexInactive', compact('classifications', 'classificationCounts', 'statusCounts', 'years'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $codes = ClassificationCode::all();
        return view('classification.create', compact('codes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassificationRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = Auth::id();
                $dept = User::where('id', $user)->first();
                $jlmActive = ClassificationCode::where('id', $request->classification_code_id)->first();
                $tahun_inactive = Carbon::parse($request->date)->year + $jlmActive->active;
                $tahun_musnah = $tahun_inactive + $jlmActive->inactive;
                
                $status = now()->year <= $tahun_musnah ? "Aktif" : "Inaktif";

                $clas = Classification::create([
                    'user_id' => $user,
                    'classification_code_id' => $request->classification_code_id,
                    'bagian' => $dept->department,
                    'nomor_berkas' => $request->nomor_berkas,
                    'nomor_item_berkas' => $request->nomor_item_berkas,
                    'uraian_berkas' => $request->uraian_berkas,
                    'date' => $request->date,
                    'jumlah' => $request->jumlah,
                    'satuan' => $request->satuan,
                    'perkembangan' => $request->perkembangan,
                    'lokasi' => $request->lokasi,
                    'box_number' => $request->box_number,
                    'tahun_inactive' => $tahun_inactive,
                    'tahun_musnah' => $tahun_musnah,
                    'status' => $status,
                    'klasifikasi_box' => 'Box Belum Dihapuskan',
                    'status_box' => '-',
                    'rak_number' => '-',
                ]);

            });

            return redirect()->route('classification.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('classification.index')
                ->with('error', 'Gagal Menyimpan Data!');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classification $classification)
    {
        $codes = ClassificationCode::all();
        return view('classification.edit', compact('classification', 'codes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassificationRequest $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $user = Auth::id();
                $classification = Classification::findOrFail($id);
                $jlmActive = ClassificationCode::where('id', $request->classification_code_id)->first();

                $tahun_inactive = Carbon::parse($request->date)->year + $jlmActive->active;
                $tahun_musnah = $tahun_inactive + $jlmActive->inactive;

                $status = now()->year <= $tahun_musnah ? "Aktif" : "Inaktif";

                $classification->update([
                    'user_id' => $user,
                    'classification_code_id' => $request->classification_code_id,
                    'nomor_berkas' => $request->nomor_berkas,
                    'nomor_item_berkas' => $request->nomor_item_berkas,
                    'uraian_berkas' => $request->uraian_berkas,
                    'date' => $request->date,
                    'jumlah' => $request->jumlah,
                    'satuan' => $request->satuan,
                    'perkembangan' => $request->perkembangan,
                    'lokasi' => $request->lokasi,
                    'box_number' => $request->box_number,
                    'tahun_inactive' => $tahun_inactive,
                    'tahun_musnah' => $tahun_musnah,
                    'status' => $status,
                ]);
            });

            return redirect()->route('classification.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('classification.index')
                ->with('error', 'Gagal Memperbarui Data!');
        }
    }
    
    
    public function editBox($id)
    {
        $classification = Classification::findOrFail($id);

        return view('classification.classification-box', compact('classification'));
    }
    
    public function updateBox(Request $request, $id) {
        $request->validate([
            'klasifikasi_box' => 'required',
            'status_box' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->klasifikasi_box == 'Box Belum Dihapuskan' && $value != '-') {
                        $fail('Status Box harus default (-) jika Klasifikasi Box adalah "Box Belum Dihapuskan".');
                    }
    
                    if (in_array($request->klasifikasi_box, ['Box Diajukan Penghapusan', 'Box Dihapuskan']) && $value == '-') {
                        $fail('Status Box tidak boleh default (-) jika Klasifikasi Box adalah "Box Diajukan Penghapusan" atau "Box Dihapuskan".');
                    }
                }
            ],
        ]);
    
        try {
            DB::transaction(function () use ($request, $id) {
                $classification = Classification::findOrFail($id);
    
                $classification->update([
                    'klasifikasi_box' => $request->klasifikasi_box,
                    'status_box' => $request->status_box,
                ]);
            });
    
            return redirect()->route('classification.inactive')->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('classification.inactive')->with('error', 'Gagal Memperbarui Data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classification $classification)
    {
        $classification->delete();
        return redirect()->route('classification.index')->with('success', 'Data berhasil dihapus.');
    }

    public function bulkUpdateBox(Request $request)
    {
        dd($request);
        
        $ids = explode(',', $request->ids);
        
        Classification::whereIn('id', $ids)->update([
            'klasifikasi_box' => $request->klasifikasi_box,
            'status_box' => $request->status_box,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }


    public function exportInaktif(Request $request)
    {
        return Excel::download(new InaktifExport, 'data_inaktif.xlsx');
    }

    public function exportBaInaktif(Request $request)
    {
        $pdf = Pdf::loadView('classification.ba.ba-pkp')->setPaper('A4', 'portrait');
        return $pdf->stream('berita_acara_pemindahan_arsip_inaktif.pdf');
        // return $pdf->download('berita_acara_pemindahan_arsip.pdf');
    }
    public function exportBaAktif(Request $request)
    {
        $pdf = Pdf::loadView('classification.ba.ba-pkp-in')->setPaper('A4', 'portrait');
        return $pdf->stream('berita_acara_pemindahan_arsip_aktif.pdf');
        // return $pdf->download('berita_acara_pemindahan_arsip.pdf');
    }
    // public function exportBaInaktif(Request $request)
    // {
    //     return view('classification.ba.ba-pkp');
    // }

    public function exportAktif(Request $request)
    {
        return Excel::download(new AktifExport, 'data_aktif.xlsx');
    }

    public function importClassificationView(Request $request)
    {
        return view('classification.import');
    }
    public function importClassification(Request $request)
    {
        $request->validate([
            'import_klasifikasi' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $import = new ClassificationImport();
            Excel::import($import, request()->file('import_klasifikasi')); 
            $import->import();
            return redirect()->route('classification.index')->with('success', 'Data berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('classification.index')->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
}


