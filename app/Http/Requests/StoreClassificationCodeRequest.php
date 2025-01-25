<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassificationCodeRequest extends FormRequest
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
            'code' => 'required|string|max:255|unique:classification_codes,code',
            'title' => 'required|string|max:255',
            'active' => 'required|integer',
            'inactive' => 'required|integer',
            'keterangan' => 'required|string',
            'security' => 'required|string',
            'hak_akses' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode klasifikasi wajib diisi.',
            'code.string' => 'Kode klasifikasi harus berupa teks.',
            'code.max' => 'Kode klasifikasi tidak boleh lebih dari 255 karakter.',
            'code.unique' => 'Kode klasifikasi sudah digunakan, harap gunakan kode lain.',

            'title.required' => 'Judul klasifikasi wajib diisi.',
            'title.string' => 'Judul klasifikasi harus berupa teks.',
            'title.max' => 'Judul klasifikasi tidak boleh lebih dari 255 karakter.',

            'active.required' => 'Masa aktif wajib diisi.',
            'active.integer' => 'Masa aktif harus berupa angka.',

            'ket_active.required' => 'Keterangan masa aktif wajib diisi.',
            'ket_active.string' => 'Keterangan masa aktif harus berupa teks.',

            'inactive.required' => 'Masa inaktif wajib diisi.',
            'inactive.integer' => 'Masa inaktif harus berupa angka.',

            'ket_inactive.required' => 'Keterangan masa inaktif wajib diisi.',
            'ket_inactive.string' => 'Keterangan masa inaktif harus berupa teks.',

            'keterangan.required' => 'Keterangan tambahan wajib diisi.',
            'keterangan.string' => 'Keterangan tambahan harus berupa teks.',

            'security.required' => 'Tingkat keamanan wajib diisi.',
            'security.string' => 'Tingkat keamanan harus berupa teks.',

            'hak_akses.required' => 'Hak akses wajib diisi.',
            'hak_akses.string' => 'Hak akses harus berupa teks.',
        ];
    }
}
