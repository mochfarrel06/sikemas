<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
        $patientsId = $this->route('patient');
        return [
            'nama_depan' => ['required', 'string'],
            'nama_belakang' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:patients,email,' . $patientsId . ',id'],
            'password' => ['nullable', 'string', 'min:8'],
            'konfirmasi_password' => ['nullable', 'same:password'],
            'no_hp' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'alamat' => ['required', 'string'],
            'negara' => ['required', 'string'],
            'provinsi' => ['required', 'string'],
            'kota' => ['required', 'string'],
            'kodepos' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'nama_depan.required' => 'Nama depan tidak boleh kosong',
            'nama_belakang.required' => 'Nama belakang tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah di tambahkan',
            'password.min' => 'Password minimal 8 karakter',
            'konfirmasi_password.same' => 'Pasword harus sama',
            'no_hp.required' => 'Nomor HP tidak boleh kosong',
            'tgl_lahir.required' => 'Tanggal lahir tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'negara.required' => 'Negara tidak boleh kosong',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'kota.required' => 'Kota tidak boleh kosong',
            'kodepos.required' => 'Kode pos tidak boleh kosong',
        ];
    }
}
