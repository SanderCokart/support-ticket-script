<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request)
    {
        $request->user()->update([
            'password' => $request->safe()->password,
        ]);

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }
}
