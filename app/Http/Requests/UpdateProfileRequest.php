<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'telephonenumber' => ['required', 'string', 'phone:NL'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone' => 'The :attribute field must be a valid NL phone number.',
        ];
    }
}
