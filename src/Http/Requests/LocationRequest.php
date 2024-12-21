<?php

namespace Dearpos\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:locations,code,'.$this->route('id')],
            'name' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:65535'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'string', 'email', 'max:100', 'unique:locations,email,'.$this->route('id')],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
