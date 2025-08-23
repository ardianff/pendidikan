<?php

namespace App\Http\Requests\Menu\Kelembagaan\Adiwiyata;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class StoreMadrasahAdiwiyataRequest extends FormRequest
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
            'nsm' => [
                'required',
                'digits:12',
                Rule::exists('master_madrasahs', 'nsm')
            ],
            'tahun' => [
                'required',
                'date_format:Y', // Validasi tahun dengan format YYYY
            ],
            'terbentuk_tim' => [
                'required',
                Rule::in(['Ya', 'Tidak']),  // Memastikan isian "Ya" atau "Tidak"
            ],
            'sk_tim' => [
                'nullable',  // Default nullable untuk tidak ada file
                'file',
                'mimes:pdf,jpg,png',  // Hanya file PDF, JPG, PNG
                'max:5120',  // Maksimal ukuran file 500KB
                // Jika terbentuk_tim = 'Ya', maka sk_tim wajib
                'required_if:terbentuk_tim,Ya',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'nsm.required' => 'NSM wajib diisi.',
            'nsm.digits' => 'NSM harus terdiri dari 12 digit.',
            'nsm.exists' => 'NSM tidak ditemukan di database.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.date_format' => 'Tahun harus menggunakan format YYYY.',
            'terbentuk_tim.required' => 'Terbentuk Tim Adiwiyata harus dipilih.',
            'terbentuk_tim.in' => 'Terbentuk Tim Adiwiyata harus bernilai "Ya" atau "Tidak".',
            'sk_tim.file' => 'File SK TIM harus berupa PDF, JPG, atau PNG.',
            'sk_tim.mimes' => 'File SK TIM harus memiliki ekstensi PDF, JPG, atau PNG.',
            'sk_tim.max' => 'Ukuran file SK TIM maksimal 500KB.',
            'sk_tim.required_if' => 'File SK TIM wajib diunggah jika Terbentuk Tim Adiwiyata bernilai "Ya".',
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
