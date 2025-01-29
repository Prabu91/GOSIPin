<?php

namespace App\Exports;

use App\Models\Classification;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LabelExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Classification::with('user', 'classificationCode')
            ->select('box_number', 'uraian_berkas', 'date', 'rak_number', 'classification_code_id', 'user_id')  // Pilih kolom yang diperlukan
            ->get();
    }

    /**
     * Menentukan heading untuk kolom
     */
    public function headings(): array
    {
        return [
            'No',
            'Nomor Box',
            'Unit Pengolah',
            'Uraian',
            'Kode Klasifikasi',
            'Tahun',
            'No. Rak',
        ];
    }

    /**
     * Mapping data sesuai kolom yang ingin ditampilkan
     */
    public function map($classification): array
    {
        static $index = 1;
        return [
            $index++,  // Nomor Urut
            $classification->box_number,
            $classification->user->department,
            $classification->uraian_berkas,
            $classification->classificationCode->code,
            Carbon::parse($classification->date)->year,
            $classification->rak_number ?? '-',
        ];
    }
}

