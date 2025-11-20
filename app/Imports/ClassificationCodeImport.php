<?php

namespace App\Imports;

use App\Models\ClassificationCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class ClassificationCodeImport implements ToModel
{
    private $current = 0;
    private $rows = [];
    private $errors = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->current++;
        if($this->current > 1 ){
            $this->rows[] = [
                'code' => $row['0'],
                'title' => $row['1'],
                'active' => $row['2'],
                'ket_active' => $row['3'],
                'inactive' => $row['4'],
                'ket_inactive' => $row['5'],
                'keterangan' => $row['6'],
                'security' => $row['7'],
                'hak_akses' => $row['8'],
            ];
        }
    }
    public function import()
    {
        DB::transaction(function () {
            foreach ($this->rows as $row) {
                $validator = Validator::make($row, [
                    'code' => 'required|string|max:255|unique:classification_codes,code',
                ]);

                if ($validator->fails()) {
                    $this->errors[] = $validator->errors()->all();
                    continue;
                }
                ClassificationCode::create($row);
            }
        });
        // Jika ada error validasi, bisa ditampilkan atau dikembalikan
        if (!empty($this->errors)) {
            throw new \Exception(json_encode($this->errors));
        }
    }
}
