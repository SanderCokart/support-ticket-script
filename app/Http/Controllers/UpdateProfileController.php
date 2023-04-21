<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
        $request->user()->update($request->validated());

        return response()->json([
            'message' => 'Profile updated successfully.',
        ]);
    }
}
