<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailRequest;
use Illuminate\Http\Request;

class UpdateEmailController extends Controller
{
    public function __invoke(UpdateEmailRequest $request)
    {
        $request->user()->update([
            'email' => $request->safe()->email,
        ]);

        return response()->json([
            'message' => 'Email updated successfully',
        ]);
    }
}
