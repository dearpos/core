<?php

namespace Dearpos\Core\Http\Requests\UnitOfMeasure;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitOfMeasureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:10', 'unique:units_of_measures,code'],
            'name' => ['required', 'string', 'max:50'],
        ];
    }
}
