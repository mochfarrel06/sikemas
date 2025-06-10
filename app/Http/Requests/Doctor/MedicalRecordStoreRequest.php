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
            'catatan_medis' => ['required', 'string'],
            'medicine_id' => ['required', 'string'],

            'gula_darah_acak' => ['nullable', 'string'],
            'gula_darah_puasa' => ['nullable', 'string'],
            'gula_darah_2jm_pp' => ['nullable', 'string'],
            'analisa_lemak' => ['nullable', 'string'],
            'cholesterol' => ['nullable', 'string'],
            'trigliserida' => ['nullable', 'string'],
            'hdl' => ['nullable', 'string'],
            'ldl' => ['nullable', 'string'],

                'asam_urat' => ['nullable', 'string'],
    'bun' => ['nullable', 'string'],
    'creatinin' => ['nullable', 'string'],
    'sgot' => ['nullable', 'string'],
    'sgpt' => ['nullable', 'string'],
    'warna' => ['nullable', 'string'],
    'ph' => ['nullable', 'string'],
    'berat_jenis' => ['nullable', 'string'],
    'reduksi' => ['nullable', 'string'],
    'protein' => ['nullable', 'string'],
    'bilirubin' => ['nullable', 'string'],
    'urobilinogen' => ['nullable', 'string'],
    'nitrit' => ['nullable', 'string'],
    'keton' => ['nullable', 'string'],
    'sedimen_lekosit' => ['nullable', 'string'],
    'sedimen_eritrosit' => ['nullable', 'string'],
    'sedimen_epitel' => ['nullable', 'string'],
    'sedimen_kristal' => ['nullable', 'string'],
    'sedimen_bakteri' => ['nullable', 'string'],
    'hemoglobin' => ['nullable', 'string'],
    'leukosit' => ['nullable', 'string'],
    'erytrosit' => ['nullable', 'string'],
    'trombosit' => ['nullable', 'string'],
    'pcv' => ['nullable', 'string'],
    'dif' => ['nullable', 'string'],
    'bleeding_time' => ['nullable', 'string'],
    'clotting_time' => ['nullable', 'string'],
    'salmonella_o' => ['nullable', 'string'],
    'salmonella_h' => ['nullable', 'string'],
    'salmonella_p_a' => ['nullable', 'string'],
    'salmonella_p_b' => ['nullable', 'string'],
    'hbsag' => ['nullable', 'string'],
    'vdrl' => ['nullable', 'string'],
    'plano_test' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'queue_id.required' => 'Antrean tidak boleh kosong',
            'diagnosis.required' => 'Diagnosis tidak boleh kosong',
            'resep.required' => 'Resep tidak boleh kosong',
            'catatan_medis.required' => 'Catatan medis tidak boleh kosong',
            'medicine_id.required' => 'Obat tidak boleh kosong'
        ];
    }
}
