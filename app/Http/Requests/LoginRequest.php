<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
                'npp' => 'required|string',
                'password' => 'required|string',
                'captcha' => 'required|captcha',
        ];
    }
    public function messages(): array
    {
        return [
            'npp.required' => 'NPP wajib diisi.',
            'password.required' => 'password wajib diisi.',
            'captcha.required' => 'CAPTCHA wajib diisi.',
            'captcha.captcha' => 'Kode CAPTCHA tidak valid.',
        ];
    }
}
