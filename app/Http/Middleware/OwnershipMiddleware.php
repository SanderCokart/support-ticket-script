<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnershipMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string  $parameter The name of the parameter in the route
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $parameter): mixed
    {

        $request->route($parameter)->user_id === $request->user()->id
            ?: abort(403, 'You are not allowed to do this');

        return $next($request);
    }
}
