<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content'   => ['required', 'string', 'max:4294967295'],
            'user_id'   => ['nullable', 'exists:users,id'],
            'ticket_id' => ['required', 'integer', 'exists:tickets,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
