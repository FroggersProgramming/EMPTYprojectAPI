<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->bearerToken() && User::where('remember_token', $request->bearerToken())->first()) {
            return $next($request);
        } else {
            return response([
                'data'  =>  '',
                'error' =>  [
                    'code'  =>  401,
                    'message'   =>  'Unauthorized',
                ],
            ],401);
        }

    }
}
