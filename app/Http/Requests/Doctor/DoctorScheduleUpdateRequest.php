<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorScheduleUpdateRequest extends FormRequest
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
            'hari' => ['nullable', 'array', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'jam_mulai' => ['nullable', 'array'],
            'jam_selesai' => ['nullable', 'array'],
            'waktu_periksa' => ['required', 'in:5,10,15,30,60'],
            'waktu_jeda' => ['required', 'in:5,10,15,30,60'],
        ];
    }

    public function messages()
    {
        return [
            'doctor_id.required' => 'Dokter tidak boleh kosong',
            'waktu_periksa.required' => 'Waktu periksa tidak boleh kosong',
            'waktu_periksa.in' => 'Waktu periksa harus berupa 5, 10, 15, 30, atau 60 menit',
            'waktu_jeda.required' => 'Waktu jeda tidak boleh kosong',
            'waktu_jeda.in' => 'Waktu jeda harus berupa 5, 10, 15, 30, atau 60 menit',
        ];
    }
}
