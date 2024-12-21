<?php

namespace Dearpos\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:3', 'unique:currencies,code,'.$this->route('id')],
            'name' => ['required', 'string', 'max:50'],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
        ];
    }
}
