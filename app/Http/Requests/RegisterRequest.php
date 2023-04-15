<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'max:255'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'telephonenumber' => ['required', 'string', 'phone:NL'],
        ];
    }
}
