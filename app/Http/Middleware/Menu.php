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

        //获取菜单列表
        $top_menus = \App\Model\Admin\Menu::getTopMenus();
        $top_menus = $top_menus->toArray();

        $path = $request->path();
        view()->share('request_path', '/'.$path);


        return $next($request);

    }
}
