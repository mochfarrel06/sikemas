<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
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
        $doctorsId = $this->route('doctor');
        return [
            'specialization_id' => ['required', 'exists:specializations,id'],
            'nama_depan' => ['required', 'string'],
            'nama_belakang' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:doctors,email,' . $doctorsId . ',id'],
            'password' => ['nullable', 'string', 'min:8'],
            'konfirmasi_password' => ['nullable', 'same:password'],
            'no_hp' => ['required', 'string'],
            'tgl_lahir' => ['required', 'date'],
            'pengalaman' => ['required', 'string'],
            'jenis_kelamin' => ['required', 'string'],
            'golongan_darah' => ['required', 'string'],
            'foto_dokter' => ['nullable', 'file', 'image', 'max:2048'],
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
            'specialization_id.required' => 'Spesialisasi tidak boleh kosong',
            'nama_depan.required' => 'Nama depan tidak boleh kosong',
            'nama_belakang.required' => 'Nama belakang tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah di tambahkan',
            'password.min' => 'Password minimal 8 karakter',
            'konfirmasi_password.same' => 'Pasword harus sama',
            'no_hp.required' => 'Nomor HP tidak boleh kosong',
            'tgl_lahir.required' => 'Tanggal lahir tidak boleh kosong',
            'pengalaman.required' => 'Pengalaman tidak boleh kosong',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
            'golongan_darah.required' => 'Golongan darah tidak boleh kosong',
            'foto_dokter.max' => 'Foto tidak boleh lebih dari 2 MB',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'negara.required' => 'Negara tidak boleh kosong',
            'provinsi.required' => 'Provinsi tidak boleh kosong',
            'kota.required' => 'Kota tidak boleh kosong',
            'kodepos.required' => 'Kode pos tidak boleh kosong',
        ];
    }
}
