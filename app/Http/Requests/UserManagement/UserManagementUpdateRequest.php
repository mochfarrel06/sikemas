<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class UserManagementUpdateRequest extends FormRequest
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
        $userId = $this->route('id');

        return [
            'nama_depan' => ['required', 'string'],
            'nama_belakang' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $userId . ',id'],
            'password' => ['nullable', 'string', 'min:8'],
            'konfirmasi_password' => ['nullable', 'same:password'],
            'role' => ['required', 'string']
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
            'role.required' => 'Nama tidak boleh kosong',
        ];
    }
}
