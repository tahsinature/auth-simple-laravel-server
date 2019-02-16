<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Illuminate\Support\Facades\DB;


class authJWT
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$token = $request->header('X-Token-Auth');
		if (!$token) return response('No token provided', 401);
		try {
			$decoded = JWTAuth::setToken($token);
			$decoded = JWTAuth::getPayload($token);
		} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			// if a token is expired
			return response('Token is expired', 401);
		} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			// if a token is invalid
			return response('Token is invalid', 401);
		}
		$user = DB::table('users')->where("email", $decoded['email'])->first();
		if(!$user) {
			return response('User not found', 404);
		}
		$request->user = $user;
		return $next($request);
	}
}
