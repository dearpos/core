<?php

namespace Dearpos\Core\Http\Requests\Currency;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:3', Rule::unique('currencies')->ignore($this->currency)],
            'name' => ['required', 'string', 'max:50'],
            'exchange_rate' => ['required', 'numeric', 'min:0'],
        ];
    }
}
