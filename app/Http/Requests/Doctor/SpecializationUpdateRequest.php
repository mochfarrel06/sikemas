<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class SpecializationUpdateRequest extends FormRequest
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
        $specializationsId = $this->route('specialization');
        return [
            'name' => ['required', 'string', 'unique:specializations,name,'. $specializationsId .',id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Spesialisasi tidak boleh kosong',
            'name.unique' => 'Spesialisasi sudah di tambahkan'
        ];
    }
}
