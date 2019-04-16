<?php

namespace App\Http\Middleware;

use App\Model\Admin\Permission;
use Closure;
use Illuminate\Support\Facades\Redis;

class Menu
{
    /**
     * Handle an incoming request.
     * @param  $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //1.根据routes配置的路由重构权限,从路由集中取出所有的route路由项
        $routes = app('routes')->getRoutes();
        $adminRoutes = [];
        foreach ($routes as $route) {
            $methods = $route->methods;
            if( in_array('GET', $methods) ){
                $method = 'GET';
            } elseif ( in_array('POST', $methods) ){
                $method = 'POST';
            } else {
                continue;
            }

            $name = isset($route->action['as']) ? $route->action['as'] : "null";

            $uri = $route->uri;
            $uriArray = explode('/',$uri);

            if( isset($uriArray[0]) && $uriArray[0]=='admin' && count($uriArray)>1 ){
                $adminRoutes[] = $method.'_'.$name.'_'.$uri;
            }
        }

        //从Redis中获取路由缓存并与路由集比对,取差集,Redis中没有的路由才能入库
        $routeCache = Redis::hGetAll('routes');
        if($routeCache){
            $adminRoutes = array_diff($adminRoutes, $routeCache);//注意参数顺序
        }

        $constants = config('constants.route');

        //差集为新加入路由文件中的路由,新路由查询和入库
        foreach ($adminRoutes as $key => $value) {
            Redis::hSet('routes', $key, $value);
            $permArray = explode('_', $value);
            //判断权限表中是否已有该记录
            $permission = Permission::findByMethodAndUri($permArray[0], $permArray[2]);
            if(!$permission){
                $description = isset($constants[$permArray[2]]) ? $constants[$permArray[2]] : "null";
                Permission::create(['description'=>$description, 'method'=>$permArray[0], 'name'=>$permArray[1], 'uri'=>$permArray[2]]);
            }
        }

        //2.获取用户权限列表
        $user = $request->user();
        $perms = $user->getPerms();

        //3.检查用户是否具有访问权限
        $callback = $request->getRouteResolver();
        $router = $callback();//当前请求的路由信息
        //$router = Route::current();//同上

        $auth = false;
        $current_perm = '';
        foreach ($perms as $perm) {
            if( in_array($perm->method, $router->methods) && $perm->uri == $router->uri){
                $auth = true;
                $current_perm = $perm;
                break;
            }
        }
        if(!$auth){
            return response()->json(['status'=>'403','message'=>'权限不足！']);
//            abort(403,'对不起，您无权访问该页面！');
        }

        //4.根据菜单表和用户权限构建个人菜单
        $top_menus = \App\Model\Admin\Menu::getTopMenus();
        $top_menus = $top_menus->toArray();
        $menus = array();
        foreach ($top_menus as $value) {
            $menus[$value['group']] = $value;
            foreach ($perms as $perm) {
                //子菜单的group属性为空
                if($perm->menu && $perm->menu->pid>0 && $perm->menu->pid == $value['id']){
                    $menus[$value['group']]['sub_menu'][] = ['name'=>$perm->menu['name'],'icon'=>$perm->menu['icon'],'link'=>'/'.$perm->uri,'sort'=>$perm->menu['sort']];
                }
            }
        }

        foreach ($menus as $key => $value) {
            if(empty($menus[$key]['sub_menu'])){
                unset($menus[$key]);
            }else{
                $menus[$key]['sub_menu'] = multisort($menus[$key]['sub_menu'],'sort');
            }
        }

        //菜单列表,当前请求URI
        view()->share('menu_list', $menus);
        $path = $request->path();
        view()->share('request_path', '/'.$path);
        if(isset($constants[$path])){
            view()->share('current_page_name', str_replace('页面', '', $constants[$path]));
        }

        //当前组名,当前菜单名
        if( $current_perm->menu ){
            $menu_group = $current_perm->menu->parent_menu->group;
            $menu_group_name = admin_group_tag($menu_group);
            $menu_name = $current_perm->menu->name;
        } else {
            $menu_group = '';
            $menu_group_name = '';
            $menu_name = '';
        }

        $route = explode('/', $router->uri());
        if( count($route) > 2 ){
            $current_route = $route[1];
        } else {
            $current_route = array_pop($route);
        }

        view()->share('current_route',$current_route);
        view()->share('menu_group', $menu_group);
        view()->share('menu_group_name', $menu_group_name);
        view()->share('menu_name', $menu_name);

        return $next($request);

    }
}
