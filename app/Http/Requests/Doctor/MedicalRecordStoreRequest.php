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
        return [
            'queue_id' => ['required', 'exists:queues,id'],
            'diagnosis' => ['required', 'string'],
            'resep' => ['required', 'string'],
            'catatan_medis' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'queue_id.required' => 'Antrean tidak boleh kosong',
            'diagnosis.required' => 'Diagnosis tidak boleh kosong',
            'resep.required' => 'Resep tidak boleh kosong',
            'catatan_medis.required' => 'Catatan medis tidak boleh kosong',
        ];
    }
}
