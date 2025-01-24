<?php

namespace App\Http\Controllers;

use App\Models\ClassificationCode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClassificationImport;

class ClassificationCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classificationCodes = ClassificationCode::paginate(100);
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
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:classification_codes,code',
            'title' => 'required|string|max:255',
            'active' => 'required|integer',
            'ket_active' => 'required|string',
            'inactive' => 'required|integer',
            'ket_inactive' => 'required|string',
            'keterangan' => 'required|string',
            'security' => 'required|string',
            'hak_akses' => 'required|string',
        ]);

        ClassificationCode::create($request->all());

        return redirect()->route('classificationCode.index')->with('success', 'Klasifikasi berhasil ditambahkan.');
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
        return view('classificationCode.edit', compact('classificationCode'));
    }

    public function update(Request $request, ClassificationCode $classificationCode)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:classification_codes,code,' . $classificationCode->id,
            'title' => 'required|string|max:255',
            'active' => 'required|integer',
            'ket_active' => 'required|string',
            'inactive' => 'required|integer',
            'ket_inactive' => 'required|string',
            'keterangan' => 'required|string',
            'security' => 'required|string',
            'hak_akses' => 'required|string',
        ]);

        $classificationCode->update($request->all());

        return redirect()->route('classificationCode.index')->with('success', 'Klasifikasi berhasil diperbarui.');
    }

    public function destroy(ClassificationCode $classificationCode)
    {
        $classificationCode->delete();
        return redirect()->route('classificationCode.index')->with('success', 'Klasifikasi berhasil dihapus.');
    }

    public function import(Request $request)
{
    $request->validate([
        'import_klasifikasi' => 'required|mimes:xlsx,xls',
    ]);

    try {
        Excel::import(new ClassificationImport, $request->file('import_klasifikasi'));
        return redirect()->route('classificationCode.index')->with('success', 'Data berhasil diimpor.');
    } catch (\Exception $e) {
        return redirect()->route('classificationCode.index')->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
    }
}


    // public function import(Request $request)
    // {
    //     Excel::import(new ClassificationImport, $request->file('import_klasifikasi'));
    //     return redirect()->route('classificationCode.index')->with('success', 'Data berhasil diimpor.');
    // }
}
