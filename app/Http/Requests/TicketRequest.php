<?php

namespace App\Http\Requests;

use App\Traits\AdminOnly;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    use AdminOnly;

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string', 'max:4294967295'],
            'user_id'     => ['nullable', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'status_id'   => ['required', 'exists:statuses,id'],
        ];
    }
}
