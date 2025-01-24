<?php

namespace App\Imports;

use App\Models\ClassificationCode;
use Maatwebsite\Excel\Concerns\ToModel;

class ClassificationImport implements ToModel
{
    private $current = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->current++;
        if($this->current > 1 ){
            return new ClassificationCode([
                'id' => \Illuminate\Support\Str::uuid(),
                'code' => $row['0'],
                'title' => $row['1'],
                'active' => $row['2'],
                'ket_active' => $row['3'],
                'inactive' => $row['4'],
                'ket_inactive' => $row['5'],
                'keterangan' => $row['6'],
                'security' => $row['7'],
                'hak_akses' => $row['8'],
            ]);
        }
    }
}
