<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Traits\GatewayTrait;
use App\Helpers\TimeHelper;

class JwtMiddleware
{
    use GatewayTrait;    

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $this->code = 498;
                $this->message = 'Token already invalidated.';
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $this->code = 498;
                $this->message = 'Token has expired';
            }else{
                $this->code = 498;
                $this->message = 'Authorization Token not found';
            }
            $result['elapsed'] = TimeHelper::server_elapsed_time();
            return $this->json();
        }
        return $next($request);
    }
}