<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class QueueStoreRequest extends FormRequest
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
            'doctor_id' => ['required', 'exists:doctors,id'],
            'tgl_periksa' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'keterangan' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Data dokter tidak boleh kosong',
            'tgl_periksa.required' => 'Tanggal periksa tidak boleh kosong',
            'start_time.required' => 'Waktu mulai tidak boleh kosong',
            'end_time.required' => 'Waktu selesai tidak boleh kosong',
            'keterangan.required' => 'Keterangan tidak boleh kosong'
        ];
    }
}
