<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'current_password'],
        ];
    }
}
