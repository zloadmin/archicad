<?php

namespace App\Http\Middleware;

use Closure;

class ListAuthenticate
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
        $login = getenv('AUTH_LIST_USERNAME');
        $pass = getenv('AUTH_LIST_PASSWORD');

        if(@($_SERVER['PHP_AUTH_PW']!= $pass || $_SERVER['PHP_AUTH_USER'] != $login)|| !$_SERVER['PHP_AUTH_USER'])
        {
            header('WWW-Authenticate: Basic realm="Test auth"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Auth failed';
            exit;
        } else {
            return $next($request);
        }
    }
}
