<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'assignee_id' => ['nullable', 'exists:users,id,is_admin,1'],
        ];
    }
}
