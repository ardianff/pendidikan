<?php

namespace App\Http\Requests\Menu\Import\Madrasah;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreImportMadrasahRequest extends FormRequest
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
            // Jenjang pendidikan harus berupa angka antara 1 hingga 5
            'jenjang' => 'required|in:1,2,3,4,5',

            // Validasi untuk file dokumen (hanya Excel)
            'file_dokumen' => 'required|file|mimes:xlsx,xls|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'jenjang.required' => 'Jenjang pendidikan harus dipilih.',
            'jenjang.in' => 'Jenjang pendidikan yang dipilih tidak valid. Pilih salah satu dari: 1 - Raudhatul Athfal, 2 - Madrasah Ibtidaiyah, 3 - Madrasah Tsanawiyah, 4 - Madrasah Aliyah, 5 - Madrasah Aliyah Kejuruan.',

            'file_dokumen.required' => 'File dokumen wajib diunggah.',
            'file_dokumen.file' => 'File yang diunggah harus berupa file.',
            'file_dokumen.mimes' => 'File yang diunggah harus berupa file Excel (.xlsx atau .xls).',
            'file_dokumen.max' => 'File yang diunggah tidak boleh lebih dari 2 MB.',
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
