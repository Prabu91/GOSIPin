<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassificationRequest;
use App\Http\Requests\UpdateClassificationRequest;
use App\Models\Classification;
use App\Models\ClassificationCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = Classification::with('classificationCode','user')->paginate(50);
        return view('classification.index', compact('classifications'));
    }

    public function indexActive()
    {
        $classifications = Classification::with('classificationCode','user')->where('status','aktif')->paginate(50);
        return view('classification.indexActive', compact('classifications'));
    }

    public function indexInactive()
    {
        $classifications = Classification::with('classificationCode','user')->where('status','inaktif')->paginate(50);
        
        // Hitung jumlah data berdasarkan klasifikasi_box
        $classificationCounts = Classification::where('status', 'inaktif')
        ->get()
        ->groupBy('klasifikasi_box')
        ->map(fn ($items) => $items->count());

        // Hitung jumlah data berdasarkan status_box
        $statusCounts = Classification::where('status', 'inaktif')
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
}
