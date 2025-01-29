<?php

namespace App\Http\Controllers;

use App\Exports\InaktifExport;
use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;
use App\Models\Classification;
use App\Models\ClassificationCode;
use App\Models\User;
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

        $classifications = $query->orderBy('box_number', 'asc')->paginate(10);

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
            $klasifikasiBox = $request->input('klasifikasi_box');
            $query->where('klasifikasi_box', $klasifikasiBox);
        }

        // Filter berdasarkan status_box
        if ($request->has('status_box')) {
            $statusBox = $request->input('status_box');
            $query->where('status_box', $statusBox);
        }

        // Ambil data berdasarkan query yang telah difilter
        $classifications = $query->orderBy('box_number', 'asc')->paginate(50);

        // Hitung jumlah data berdasarkan klasifikasi_box dengan filter 'bagian'
        $classificationCounts = Classification::where('status', 'inaktif')
            ->when($user->role === 'UP', function ($q) use ($user) {
                return $q->where('bagian', $user->department); 
            })
            ->get()
            ->groupBy('klasifikasi_box')
            ->map(fn ($items) => $items->count());

        // Hitung jumlah data berdasarkan status_box dengan filter 'bagian'
        $statusCounts = Classification::where('status', 'inaktif')
            ->when($user->role === 'UP', function ($q) use ($user) {
                return $q->where('bagian', $user->department); 
            })
            ->get()
            ->groupBy('status_box')
            ->map(fn ($items) => $items->count());

        return view('classification.indexInactive', compact('classifications', 'classificationCounts', 'statusCounts'));
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

    public function exportInaktif(Request $request)
    {
        return Excel::download(new InaktifExport, 'data_inaktif.xlsx');
    }
}
