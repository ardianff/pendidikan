<?php

namespace App\Http\Requests\Menu\Madrasah\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class CheckMadrasahRequest extends FormRequest
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
            // 'nsm' => 'required|digits:12|exists:master_madrasahs,nsm',
            'nsm' => [
                'required',
                'digits:12',
                Rule::exists('master_madrasahs', 'nsm')
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'nsm.required' => 'NSM wajib diisi.',
            'nsm.digits' => 'NSM harus berupa angka dan terdiri dari 12 digit.',
            'nsm.exists' => 'NSM yang dimasukkan tidak terdaftar di sistem.',  // Pesan untuk validasi exists
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Ada kesalahan.',
                'errors'  => $errors
            ], 422)
        );
    }
}
