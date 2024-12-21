<?php

namespace Dearpos\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitOfMeasureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:10', 'unique:units_of_measures,code,'.$this->route('id')],
            'name' => ['required', 'string', 'max:50'],
        ];
    }
}
