<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassificationCodeRequest;
use App\Models\ClassificationCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClassificationCodeImport;
use Illuminate\Support\Facades\DB;

class ClassificationCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ClassificationCode::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('code', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%");
        }

        $classificationCodes = $query->orderBy('code', 'asc')->paginate(100);

        return view('classification-code.index', compact('classificationCodes'));
    }


    public function importView(Request $request)
    {
        return view('classification-code.import');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('classification-code.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassificationCodeRequest $request)
    {
        DB::transaction(function () use ($request) {
            ClassificationCode::create([
                'code' => $request->code,
                'title' => $request->title,
                'active' => $request->active,
                'ket_active' => $request->ket_active,
                'inactive' => $request->inactive,
                'ket_inactive' => $request->ket_inactive,
                'keterangan' => $request->keterangan,
                'security' => $request->security,
                'hak_akses' => $request->hak_akses,
            ]);
        });

        return redirect()->route('classificationCode.index')->with('success', 'Kode Klasifikasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(ClassificationCode $classificationCode)
    {
        return view('classification-code.edit', compact('classificationCode'));
    }

    public function update(Request $request, ClassificationCode $classificationCode)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:classification_codes,code,' . $classificationCode->id,
            'title' => 'required|string|max:255',
            'active' => 'required|integer',
            'inactive' => 'required|integer',
            'keterangan' => 'required|string',
            'security' => 'required|string',
            'hak_akses' => 'required|string',
        ]);

        DB::transaction(function () use ($request,$classificationCode) {
            $classificationCode->update([
                'code' => $request->code,
                'title' => $request->title,
                'active' => $request->active,
                'ket_active' => $request->ket_active,
                'inactive' => $request->inactive,
                'ket_inactive' => $request->ket_inactive,
                'keterangan' => $request->keterangan,
                'security' => $request->security,
                'hak_akses' => $request->hak_akses,
            ]);
        });

        return redirect()->route('classificationCode.index')->with('success', 'Kode Klasifikasi berhasil diperbarui.');
    }

    public function destroy(ClassificationCode $classificationCode)
    {
        $classificationCode->delete();
        return redirect()->route('classificationCode.index')->with('success', 'Kode Klasifikasi berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_klasifikasi' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $import = new ClassificationCodeImport();
            Excel::import($import, request()->file('import_klasifikasi')); 
            $import->import();
            return redirect()->route('classificationCode.index')->with('success', 'Data berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->route('classificationCode.index')->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

}
