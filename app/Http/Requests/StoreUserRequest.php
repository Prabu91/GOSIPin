<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'npp' => 'required|numeric|unique:users,npp',
            'password' => 'required|min:6',
            'role' => 'required|in:UK,Pegawai',
            'department' => 'required|in:PMU,YANFASKES,YANSER,KEPSER,PKP,SDMUK',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'npp.required' => 'NPP wajib diisi.',
            'npp.numeric' => 'NPP harus berupa angka.',
            'npp.unique' => 'NPP sudah terdaftar, gunakan NPP lain.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus memiliki minimal 6 karakter.',

            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role harus salah satu dari: UK atau Pegawai.',

            'department.required' => 'Departemen wajib dipilih.',
            'department.in' => 'Departemen harus salah satu dari: PMU, YANFASKES, YANSER, KEPSER, PKP, atau SDMUK.',
        ];
    }
}
