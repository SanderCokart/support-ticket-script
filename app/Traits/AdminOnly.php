<?php

namespace App\Traits;

trait AdminOnly
{
    public function authorize(): bool
    {
        return auth()->user()->is_admin;
    }
}
