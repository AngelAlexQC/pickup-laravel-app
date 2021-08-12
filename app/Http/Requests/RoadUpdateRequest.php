<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoadUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'address_start_id' => ['nullable', 'exists:addresses,id'],
            'address_end_id' => ['nullable', 'exists:addresses,id'],
            'meta' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
        ];
    }
}
