<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'dni' => [
                'required',
                Rule::unique('users')->ignore($this->user->id, 'id'),
                'max:255',
                'string',
            ],
            'name' => ['required', 'max:255', 'string'],
            'first_name' => ['required', 'max:255', 'string'],
            'last_name' => ['required', 'max:255', 'string'],
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->user->id, 'id'),
                'email',
            ],
            'meta' => ['required', 'max:255', 'string'],
            'roles' => 'array',
        ];
    }
}
