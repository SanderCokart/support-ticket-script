<?php

namespace App\Http\Requests;

use App\Traits\AdminOnly;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    use AdminOnly;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
        ];
    }
}
