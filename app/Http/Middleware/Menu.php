<?php

namespace App\Http\Middleware;

use Closure;

class Menu
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

        //菜单列表,当前请求uri
        $path = $request->path();
        view()->share('request_path', '/'.$path);

        return $next($request);

    }
}
