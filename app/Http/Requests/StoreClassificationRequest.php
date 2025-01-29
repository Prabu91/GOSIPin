<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'classification_code_id' => 'required|uuid',
            'nomor_berkas' => 'required|integer',
            'nomor_item_berkas' => 'required|integer',
            'uraian_berkas' => 'required|string',
            'date' => 'required',
            'jumlah' => 'required|integer',
            'satuan' => 'required|string',
            'perkembangan' => 'required|string',
            'lokasi' => 'required|in:rak,shelf,box',
            'box_number' => 'required|string|unique:classification_tables,box_number',
        ];
    }

    public function messages(): array
    {
        return [

            'classification_code_id.required' => 'Judul berkas wajib dipilih.',
            'classification_code_id.exists' => 'Judul berkas yang dipilih tidak valid.',

            'nomor_berkas.required' => 'Nomor berkas wajib diisi.',
            'nomor_berkas.integer' => 'Nomor berkas harus berupa angka.',

            'nomor_item_berkas.required' => 'Nomor item berkas wajib diisi.',
            'nomor_item_berkas.integer' => 'Nomor item berkas harus berupa angka.',

            'uraian_berkas.required' => 'Uraian berkas wajib diisi.',
            'uraian_berkas.string' => 'Uraian berkas harus berupa teks.',

            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',

            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',

            'satuan.required' => 'Satuan wajib diisi.',
            'satuan.string' => 'Satuan harus berupa teks.',

            'perkembangan.required' => 'Perkembangan wajib diisi.',
            'perkembangan.string' => 'Perkembangan harus berupa teks.',

            'lokasi.required' => 'Lokasi wajib dipilih.',
            'lokasi.in' => 'Lokasi harus berupa rak, shelf, atau box.',

            'box_number.required' => 'Nomor Box wajib diisi.',
            'box_number.string' => 'Nomor Box harus berupa teks.',
            'box_number.unique' => 'Nomor Box sudah ada.',

            'tahun_inactive.required' => 'Tahun inaktif wajib diisi.',
            'tahun_inactive.date' => 'Format tahun inaktif tidak valid.',

            'tahun_musnah.required' => 'Tahun musnah wajib diisi.',
            'tahun_musnah.date' => 'Format tahun musnah tidak valid.',
        ];
    }

}
