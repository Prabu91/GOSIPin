<?php

namespace App\Imports;

use App\Models\Classification;
use App\Models\ClassificationCode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ClassificationImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $rows = [];

    public function model(array $row)
    {
        $user = Auth::id();
        $dept = User::where('id', $user)->first();
        $classificationCode = ClassificationCode::where('code', $row['code'])->first();

        $this->rows[] = [
            'user_id' => Auth::id(),
            'classification_code_id' => $classificationCode ? $classificationCode->id : null,
            'bagian' => $dept->department,
            'nomor_berkas' => $row['nomor_berkas'],
            'nomor_item_berkas' => $row['nomor_item_berkas'],
            'uraian_berkas' => $row['uraian_berkas'],
            'date' => is_numeric($row['date']) 
                ? Carbon::instance(Date::excelToDateTimeObject($row['date']))->format('Y-m-d')
                : Carbon::parse($row['date'])->format('Y-m-d'),
            'jumlah' => $row['jumlah'],
            'satuan' => $row['satuan'],
            'perkembangan' => $row['perkembangan'],
            'lokasi' => $row['lokasi'],
            'box_number' => $row['box_number'],
            'tahun_inactive' => $row['tahun_inactive'],
            'tahun_musnah' => $row['tahun_musnah'],
            'status' => $row['status'],
            'klasifikasi_box' => $row['klasifikasi_box'],
            'status_box' => $row['status_box'],
            'rak_number' => $row['rak_number'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function batchSize(): int
    {
        return 100; // Proses dalam batch 100 data
    }

    public function chunkSize(): int
    {
        return 100; // Membaca dalam chunk 100 baris untuk hemat memori
    }

    public function import()
    {
        DB::transaction(function () {
            if (!empty($this->rows)) {
                Classification::insert($this->rows); // Bulk insert ke database
            }
        });
    }
}
