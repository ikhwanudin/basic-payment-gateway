<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasApiSecretToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (
            $request->bearerToken() !== config('api.secret')
        ) {
            return response()->json([
                'error' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
