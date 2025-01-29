<?php

namespace App\Exports;

use App\Models\Classification;
use App\Models\ClassificationCode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class InaktifExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Classification::with('user','classificationCode')->where('status', 'inaktif')->get();
    }

    /**
     * Menentukan heading untuk kolom
     */
    public function headings(): array
    {
        return [
            'No',
            'Unit Pengolah',
            'Nomor Berkas',
            'Judul Berkas',
            'Nomor Item Berkas',
            'Kode Klasifikasi',
            'Uraian Informasi Isi Berkas',
            'Kurun Waktu',
            'Tahun',
            'Jumlah',
            'Satuan',
            'Tingkat Perkembangan',
            'Dimusnahkan Aktif',
            'Dimusnahkan Inaktif',
            'Keterangan',
            'Rak',
            'Shelf',
            'Boks',
            'Klasifikasi Keamanan',
            'Hak Akses (Pejabat Yang Bertanggung Jawab)',
            'No. Box',
            'Tahun Inaktif',
            'Tahun Pemusnahan',
            'Inaktif',
            'Klasifikasi Box',
            'Status',
        ];
    }

    /**
     * Mapping data sesuai kolom yang ingin ditampilkan
     */
    public function map($classification): array
    {
        static $index = 1;
    
        // Perhitungan tahun inaktif dan tahun pemusnahan
        $tahun_inaktif = Carbon::parse($classification->date)->year + $classification->classificationCode->active;
        $tahun_pemusnahan = $tahun_inaktif + $classification->classificationCode->inactive;

        if ($classification->status_box !== '-') {
            $statusBox = $classification->status_box;
        } elseif ($classification->tahun_musnah < now()->year) {
            $statusBox = 'Bisa Dimusnahkan';
        } elseif ($classification->tahun_musnah >= now()->year) {
            $statusBox = 'Belum Bisa Dimusnahkan';
        } else {
            $statusBox = '-';
        }

        return [
            $index++,
            $classification->user->department,
            $classification->nomor_berkas,
            $classification->classificationCode->title,
            $classification->nomor_item_berkas,
            $classification->classificationCode->code,
            $classification->uraian_berkas,
            Carbon::parse($classification->date)->isoFormat('MMMM'), 
            Carbon::parse($classification->date)->year, 
            $classification->jumlah,
            $classification->satuan,
            $classification->perkembangan,
            $classification->classificationCode->active.' Tahun '. $classification->classificationCode->ket_active,
            $classification->classificationCode->inactive.' Tahun '. $classification->classificationCode->ket_inactive,
            $classification->classificationCode->keterangan,

            $this->getLocationSymbol('rak', $classification->lokasi), 
            $this->getLocationSymbol('shelf', $classification->lokasi),
            $this->getLocationSymbol('box', $classification->lokasi),

            $classification->classificationCode->security,
            $classification->classificationCode->hak_akses.' '.$classification->user->department,

            $classification->box_number,
            $tahun_inaktif,
            $tahun_pemusnahan,
            $classification->status,
            $classification->klasifikasi_box,
            $statusBox,  
        ];
    }

    private function getLocationSymbol($type, $location)
    {
        return $type == $location ? '✓' : '-';
    }
}
