<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassificationRequest extends FormRequest
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
            'nomor_berkas' => 'required|numeric|unique:classification_tables,nomor_berkas,' . $this->route('classification'),
            'classification_code_id' => 'required|exists:classification_codes,id',
            'nomor_item_berkas' => 'required|numeric',
            'uraian_berkas' => 'required|string|max:255',
            'date' => 'required|date',
            'jumlah' => 'required|numeric',
            'satuan' => 'required|string|max:100',
            'perkembangan' => 'required|string|max:255',
            'lokasi' => 'required|in:rak,shelf,box',
            'ket_lokasi' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nomor_berkas.required' => 'Nomor Berkas harus diisi.',
            'nomor_berkas.numeric' => 'Nomor Berkas harus berupa angka.',
            'nomor_berkas.unique' => 'Nomor Berkas sudah terdaftar.',
            'classification_code_id.required' => 'Judul Berkas harus dipilih.',
            'classification_code_id.exists' => 'Judul Berkas yang dipilih tidak valid.',
            'nomor_item_berkas.required' => 'Nomor Item Berkas harus diisi.',
            'nomor_item_berkas.numeric' => 'Nomor Item Berkas harus berupa angka.',
            'uraian_berkas.required' => 'Uraian Berkas harus diisi.',
            'uraian_berkas.string' => 'Uraian Berkas harus berupa teks.',
            'uraian_berkas.max' => 'Uraian Berkas tidak boleh lebih dari 255 karakter.',
            'date.required' => 'Tanggal harus diisi.',
            'date.date' => 'Format Tanggal tidak valid.',
            'jumlah.required' => 'Jumlah harus diisi.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'satuan.required' => 'Satuan harus diisi.',
            'satuan.string' => 'Satuan harus berupa teks.',
            'satuan.max' => 'Satuan tidak boleh lebih dari 100 karakter.',
            'perkembangan.required' => 'Tingkat Perkembangan harus diisi.',
            'perkembangan.string' => 'Tingkat Perkembangan harus berupa teks.',
            'perkembangan.max' => 'Tingkat Perkembangan tidak boleh lebih dari 255 karakter.',
            'lokasi.required' => 'Lokasi harus dipilih.',
            'lokasi.in' => 'Lokasi yang dipilih tidak valid.',
            'ket_lokasi.required' => 'Keterangan Lokasi harus diisi.',
            'ket_lokasi.string' => 'Keterangan Lokasi harus berupa teks.',
            'ket_lokasi.max' => 'Keterangan Lokasi tidak boleh lebih dari 255 karakter.',
        ];
    }
}
