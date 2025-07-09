<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class MedicalRecordStoreRequest extends FormRequest
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
        $user = auth()->user();

        // Rules untuk admin - hanya bisa input data vital
        if ($user->role === 'admin') {
            return [
                'queue_id' => ['required', 'exists:queues,id'],
                'tinggi_badan' => ['required', 'string', 'max:10'],
                'berat_badan' => ['required', 'string', 'max:10'],
                'tekanan_darah' => ['required', 'string', 'max:15'],
            ];
        }

        // Rules untuk dokter - bisa input semua kecuali data vital (readonly)
        if ($user->role === 'doctor') {
            return [
                'queue_id' => ['required', 'exists:queues,id'],
                'diagnosis' => ['required', 'string'],
                'resep' => ['required', 'string'],
                'catatan_medis' => ['required', 'string'],
                'medicine_id' => 'required|array',
                'medicine_id.*' => 'exists:medicines,id',
                // Data vital tidak divalidasi karena readonly
                'tinggi_badan' => ['nullable', 'string', 'max:10'],
                'berat_badan' => ['nullable', 'string', 'max:10'],
                'tekanan_darah' => ['nullable', 'string', 'max:15'],
            ];
        }

        // Default rules (fallback)
        return [
            'queue_id' => ['required', 'exists:queues,id'],
            'diagnosis' => ['required', 'string'],
            'resep' => ['required', 'string'],
            'catatan_medis' => ['required', 'string'],
            'tinggi_badan' => ['nullable', 'string', 'max:10'],
            'berat_badan' => ['nullable', 'string', 'max:10'],
            'tekanan_darah' => ['nullable', 'string', 'max:15'],
            'medicine_id' => 'required|array',
            'medicine_id.*' => 'exists:medicines,id',
        ];
    }

    public function messages()
    {
        $user = auth()->user();

        $baseMessages = [
            'queue_id.required' => 'Antrean tidak boleh kosong',
            'tinggi_badan.required' => 'Tinggi badan tidak boleh kosong',
            'tinggi_badan.max' => 'Tinggi badan maksimal 10 karakter',
            'berat_badan.required' => 'Berat badan tidak boleh kosong',
            'berat_badan.max' => 'Berat badan maksimal 10 karakter',
            'tekanan_darah.required' => 'Tekanan darah tidak boleh kosong',
            'tekanan_darah.max' => 'Tekanan darah maksimal 15 karakter',
        ];

        if ($user->role === 'doctor') {
            $baseMessages = array_merge($baseMessages, [
                'diagnosis.required' => 'Diagnosis tidak boleh kosong',
                'resep.required' => 'Resep tidak boleh kosong',
                'catatan_medis.required' => 'Catatan medis tidak boleh kosong',
                'medicine_id.required' => 'Obat tidak boleh kosong',
            ]);
        }

        return $baseMessages;
    }
}