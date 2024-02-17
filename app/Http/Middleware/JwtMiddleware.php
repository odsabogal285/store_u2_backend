<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         try {
             JWTAuth::parseToken()->authenticate();
         } catch (Exception $exception) {
             if ($exception instanceof TokenInvalidException) {
                 return response()->json([
                     'response' => 'error',
                     'data' => null,
                     'error' => 'Invalid Token'
                 ], 401);
             }

             if ($exception instanceof TokenExpiredException) {
                 return response()->json([
                     'response' => 'error',
                     'data' => null,
                     'error' => 'Expired token Token'
                 ], 401);
             }

             return response()->json([
                 'response' => 'error',
                 'data' => null,
                 'error' => $exception->getMessage()
             ], 401);
         }

        return $next($request);
    }
}
