<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassificationRequest;
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
        $classifications = Classification::with('classificationCode','user')->where('status','active')->paginate(50);
        return view('classification.indexActive', compact('classifications'));
    }

    public function indexInactive()
    {
        $classifications = Classification::with('classificationCode','user')->where('status','inactive')->paginate(50);
        return view('classification.indexInactive', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $codes = ClassificationCode::all();
        return view('classification.create', compact('users', 'codes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassificationRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = Auth::id();
                $jlmActive = ClassificationCode::where('id', $request->classification_code_id)->first();

                $tahun_inactive = Carbon::parse($request->date)->year + $jlmActive->active;
                $tahun_musnah = $tahun_inactive + $jlmActive->inactive;

                $status = now()->year <= $tahun_musnah ? "Active" : "Inactive";

                $clas = Classification::create([
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
                    'ket_lokasi' => $request->ket_lokasi,
                    'tahun_inactive' => $tahun_inactive,
                    'tahun_musnah' => $tahun_musnah,
                    'status' => $status,
                ]);

            });

            return redirect()->route('classification.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('classification.index')
                ->with('error', 'Gagal Menyimpan Data!');
        }
        
    }

//     public function store(Request $request)
// {
//     // dd($jlmActive); // Jika ini tampil, berarti request masuk
    
//     // DB::beginTransaction();
//     // try {
//         $user = Auth::id();
        
//         $jlmActive = ClassificationCode::where('id', $request->classification_code_id)->first();
//         if (!$jlmActive) {
//             throw new \Exception('Kode klasifikasi tidak ditemukan.');
//         }
        
//         $tahun_inactive = Carbon::parse($request->date)->year + $jlmActive->active;
//         $tahun_musnah = $tahun_inactive + $jlmActive->inactive;
//         $status = now()->year <= $tahun_musnah ? "Active" : "Inactive";

//         $clas = Classification::create([
//             'user_id' => $user,
//             'classification_code_id' => $request->classification_code_id,
//             'nomor_berkas' => $request->nomor_berkas,
//             'nomor_item_berkas' => $request->nomor_item_berkas,
//             'uraian_berkas' => $request->uraian_berkas,
//             'date' => $request->date,
//             'jumlah' => $request->jumlah,
//             'satuan' => $request->satuan,
//             'perkembangan' => $request->perkembangan,
//             'lokasi' => $request->lokasi,
//             'ket_lokasi' => $request->ket_lokasi,
//             'tahun_inactive' => $tahun_inactive,
//             'tahun_musnah' => $tahun_musnah,
//             'status' => $status,
//         ]);

//         // DB::commit();

//         // dd($clas); // Jika tidak tampil, berarti kode sebelum ini gagal
//     } catch (\Exception $e) {
//         DB::rollback();
//         return back()->with('error', 'Gagal Menyimpan Data: ' . $e->getMessage());
//     }
    
//     return redirect()->route('classification.index')->with('success', 'Data berhasil ditambahkan.');
// }


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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
