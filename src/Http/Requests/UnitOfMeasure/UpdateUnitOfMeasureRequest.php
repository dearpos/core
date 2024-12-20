<?php

namespace Dearpos\Core\Http\Requests\UnitOfMeasure;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitOfMeasureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:10', Rule::unique('units_of_measures')->ignore($this->unit_of_measure)],
            'name' => ['required', 'string', 'max:50'],
        ];
    }
}
